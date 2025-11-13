<?php

namespace App\Http\Controllers;

use App\Models\PostReadModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostReadController extends Controller
{
    public function toggleRead(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,post_id',
        ]);

        $userId = Auth::id();
        $postId = $validated['post_id'];

        // Check if already marked as read
        $existing = PostReadModel::where('user_id', $userId)
            ->where('post_id', $postId)
            ->first();

        if ($existing) {
            // Already read, so unmark it
            $existing->delete();
            return response()->json(['status' => 'unread']);
        } else {
            // Mark as read
            PostReadModel::create([
                'user_id' => $userId,
                'post_id' => $postId,
            ]);
            return response()->json(['status' => 'read']);
        }
    }
}
