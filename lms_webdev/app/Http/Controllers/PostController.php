<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
use App\Models\NotificationModel;
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
            return view('new_post', ['code' => $code, 'class' => $class]);
        } elseif ($routeName === 'assignments.create') {
            return view('new_assignment', ['code' => $code, 'class' => $class]);
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
            'post_type'      => 'required|in:material,assignment,announcement',
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'color'          => 'nullable|in:pink,blue,purple,yellow',
            'due_date'       => 'nullable|date',
            'material_file'  => 'nullable|file|max:10240', 
            'material_link'  => 'nullable|url',
        ]);

        $title = $validated['title'];
        $content = $validated['description'];

        $classExists = DB::table('classes')->where('code', $code)->exists();
        if (! $classExists) {
            return back()->withErrors(['code' => 'Class not found.'])->withInput();
        }

        $postData = [
            'user_id'    => Auth::id(),
            'code'       => $code, 
            'post_title' => $title,
            'post_type'  => $validated['post_type'],
            'content'    => $content,
            //'avatar'     => '', 
        ];

        if (!empty($validated['color'])) {
            $postData['color'] = $validated['color'];
        }

        if (!empty($validated['due_date'])) {
            $postData['due_date'] = $validated['due_date'];
        }

        if ($validated['post_type'] === 'material' && $request->hasFile('material_file')) {
            $file = $request->file('material_file');
            $fileName = time() . '_' . Auth::id() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materials', $fileName, 'public');
            $postData['file_path'] = $filePath;
        }

        if ($validated['post_type'] === 'material' && !empty($validated['material_link'])) {
            $postData['file_link'] = $validated['material_link'];
        }

        try {
            $post = PostModel::create($postData);

            $classMembers = DB::table('class_users')
                ->where('class_code', $code)
                ->where('user_id', '!=', Auth::id())
                ->pluck('user_id');

            foreach ($classMembers as $memberId) {
                NotificationModel::create([
                    'user_id'   => $memberId,
                    'message'   => Auth::user()->name . " posted a new {$validated['post_type']}: {$title}",
                    'type'      => $validated['post_type'],
                    'url'       => route('classes.show', ['code' => $code]),
                    'meta'      => json_encode(['post_id' => $post->post_id ?? $post->id ?? null, 'code' => $code]),
                    'is_read'   => false,
                ]);
            }

            return redirect()->route('classes.show', ['code' => $code])
                            ->with('success', 'Post created successfully!');

        } catch (\Throwable $e) {
            Log::error('Error creating post', [
                'exception' => $e->getMessage(),
                'data' => $postData,
            ]);
            return back()->with('error', 'Server error while creating post. Check logs.')->withInput();
        }
    }

    public function newAssignment(Request $request, $code)
    {
        $validatedData = $request->validate([
            'due_date' => ['required', 'date', 'after_or_equal:' . now()->format('Y-m-d H:i')],
            'title' => 'required|max:255',
            'instructions' => 'required|string',
            'assignment_file' => 'nullable|file|max:10240',
            'assignment_link' => 'nullable|url',
        ]);

        $assignmentData = [
            'user_id'    => Auth::id(),
            'code'       => $code,
            'post_title' => $validatedData['title'],
            'post_type'  => 'assignment',
            'content'    => $validatedData['instructions'] ?? null,
            'due_date'   => $validatedData['due_date'],
            //'avatar'     => '', 
        ];

        if ($request->hasFile('assignment_file')) {
            $file = $request->file('assignment_file');
            $fileName = time() . '_' . Auth::id() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('assignments', $fileName, 'public');
            $assignmentData['file_path'] = $filePath;
        }

        if (!empty($validatedData['assignment_link'])) {
            $assignmentData['file_link'] = $validatedData['assignment_link'];
        }

        $assignmentPost = PostModel::create($assignmentData);

        // notify class members about the new assignment
        $classMembers = DB::table('classmembers')
            ->where('code', $code)
            ->where('user_id', '!=', Auth::id())
            ->pluck('user_id');

        foreach ($classMembers as $memberId) {
            NotificationModel::create([
                'user_id' => $memberId,
                'message' => Auth::user()->name . " posted a new assignment: {$assignmentData['post_title']}",
                'type'    => 'assignment',
                'url'     => route('classes.show', ['code' => $code]),
                'meta'    => json_encode(['post_id' => $assignmentPost->post_id ?? $assignmentPost->id ?? null, 'code' => $code]),
                'is_read' => false,
            ]);
        }

        return redirect()->route('classes.show', ['code' => $code])
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
                'material_file' => 'nullable|file|max:10240',
                'material_link' => 'nullable|url',
            ]);

            $post = PostModel::where('post_id', $validated['post_id'])->first();

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found'
                ], 404);
            }

            if ($post->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to edit this post'
                ], 403);
            }

            $post->post_title = $validated['post_title'];
            $post->content = $validated['content'];

            if ($validated['post_type'] === 'assignment' && isset($validated['due_date'])) {
                $post->due_date = $validated['due_date'];
            }

            if (in_array($validated['post_type'], ['material', 'assignment']) && $request->hasFile('material_file')) {
                $file = $request->file('material_file');
                $fileName = time() . '_' . Auth::id() . '_' . $file->getClientOriginalName();
                $folder = $validated['post_type'] === 'material' ? 'materials' : 'assignments';
                $filePath = $file->storeAs($folder, $fileName, 'public');
                $post->file_path = $filePath;
                $post->file_link = null;
            }
            elseif (in_array($validated['post_type'], ['material', 'assignment']) && !empty($validated['material_link'])) {
                $post->file_link = $validated['material_link'];
                $post->file_path = null; 
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