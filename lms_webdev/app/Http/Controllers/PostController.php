<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function create(Request $request)
    {
        $routeName = $request->route()->getName();
        
        if ($routeName === 'posts.create') {
            return view('new_post');
        } elseif ($routeName === 'assignments.create') {
            return view('new_assignment');
        }
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

    public function newPost(Request $request)
    {
        $validated = $request->validate([
            'post_type' => 'required|in:material,assignment,announcement',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'code' => 'required|string|exists:classes,code',
            'color' => 'nullable|string', // Add color validation if needed
        ]);
        
        $classId = DB::table('classes')->where('code', $validated['code'])->value('class_id');

        if (!$classId) {
            return back()->withErrors(['code' => 'Class with provided code not found.'])->withInput();
        }

        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $postData = [
            'user_id' => Auth::id(),
            'class_id' => $classId,
            'post_title' => $validated['title'], 
            'post_type' => $validated['post_type'],
            'content' => $validated['description'],
        ];

        // Only add color if it's present in the request
        if (isset($validated['color'])) {
            $postData['color'] = $validated['color'];
        }

        PostModel::create($postData);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }
    public function newAssignment(Request $request)
    {
        $validatedData = $request->validate([
            'due_date' => ['required', 'date', 'after_or_equal:' . now()->format('Y-m-d H:i')],
            'title' => 'required|max:255',
            'instructions' => 'nullable|string',
        ]);

        PostModel::create($validatedData);

        return redirect()->route('assignments.index')
                         ->with('success', 'Assignment created successfully!');
    }
}