<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function create(Request $request, $code)
    {
        $routeName = $request->route()->getName();
        $class = DB::table('classes')->where('code', $code)->first();

        if (!$class) {
            abort(404, 'Class not found');
        }
        if ($routeName === 'posts.create') {
            return view('new_post', ['code' => $code]);
        } elseif ($routeName === 'assignments.create') {
            return view('new_assignment', ['code' => $code]);
        }

        abort(404);
    }

    public function index(Request $request)
    {
        $routeName = $request->route()->getName();
        
        if ($routeName === 'posts.index') {
            $posts = PostModel::with('user')
                ->whereIn('post_type', ['material', 'announcement'])
                ->get();
            return view('posts.index', compact('posts'));
        } elseif ($routeName === 'assignments.index') {
            $assignments = PostModel::with('user')
                ->where('post_type', 'assignment')
                ->get();
            return view('assignments.index', compact('assignments'));
        }
    }

    public function newPost(Request $request, $code)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'post_type'   => 'required|in:material,assignment,announcement',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'color'       => 'nullable|in:pink,blue,purple,yellow',
            'due_date'    => 'nullable|date',
        ]);

        $title = $validated['title'];
        $content = $validated['description'];

        // Optional: verify that class with this code exists
        $classExists = DB::table('classes')->where('code', $code)->exists();
        if (! $classExists) {
            return back()->withErrors(['code' => 'Class not found.'])->withInput();
        }

        // Build the post data
        $postData = [
            'user_id'    => Auth::id(),
            'code'       => $code, // from the URL
            'post_title' => $title,
            'post_type'  => $validated['post_type'],
            'content'    => $content,
        ];

        if (!empty($validated['color'])) {
            $postData['color'] = $validated['color'];
        }

        if (!empty($validated['due_date'])) {
            $postData['due_date'] = $validated['due_date'];
        }

        try {
            $post = PostModel::create($postData);

            return redirect()->route('posts.index')
                            ->with('success', 'Post created successfully!');
        } catch (\Throwable $e) {
            Log::error('Error creating post', ['exception' => $e->getMessage(), 'data' => $postData]);
            return back()->with('error', 'Server error while creating post. Check logs.')->withInput();
        }
    }
    public function newAssignment(Request $request, $code)
    {
        $validatedData = $request->validate([
            'due_date' => ['required', 'date', 'after_or_equal:' . now()->format('Y-m-d H:i')],
            'title' => 'required|max:255',
            'instructions' => 'nullable|string',
        ]);

        $assignmentData = [
            'user_id'    => Auth::id(),
            'code'       => $code,
            'post_title' => $validatedData['title'],
            'post_type'  => 'assignment',
            'content'    => $validatedData['instructions'] ?? null,
            'due_date'   => $validatedData['due_date'],
        ];
                
        PostModel::create($assignmentData);

        return redirect()->route('assignments.index')
                         ->with('success', 'Assignment created successfully!');
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'post_id' => 'required|exists:posts,post_id',
                'post_title' => 'required|string|max:255',
                'content' => 'required|string',
                'post_type' => 'required|in:material,assignment,announcement',
                'due_date' => 'nullable|date',
            ]);

            // Find the post
            $post = PostModel::where('post_id', $validated['post_id'])->first();

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found'
                ], 404);
            }

            // Check if user is authorized to edit (must be the creator)
            if ($post->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to edit this post'
                ], 403);
            }

            // Update the post
            $post->post_title = $validated['post_title'];
            $post->content = $validated['content'];

            // Update due_date for assignments
            if ($validated['post_type'] === 'assignment' && isset($validated['due_date'])) {
                $post->due_date = $validated['due_date'];
            }

            $post->save();

            return response()->json([
                'success' => true,
                'message' => 'Post updated successfully',
                'post' => $post
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}