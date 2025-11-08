<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $posts = PostModel::with('user')->get();
        return view('new_post', compact('posts'));
    }
    public function create()
    {
        return view('new_post'); 
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_type' => 'required|in:material,assignment,announcement',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'code' => 'required|string|exists:classes,code',
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
            'post_title' => $validated['title'],     // Match the field name from form
            'post_type' => $validated['post_type'],
            'content' => $validated['description'],   // Match the field name from form
        ];

        PostModel::create($postData);

        return redirect()->back()->with('success', 'Post created successfully!');
    }
}