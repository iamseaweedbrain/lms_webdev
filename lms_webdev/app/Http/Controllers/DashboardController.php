<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <-- Import the DB facade

class DashboardController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();
        $currentUserId = $currentUser->user_id ?? 'default-user-id';
        $userFirstName = $currentUser->firstname ?? 'Guest'; 
        
        $pastelColors = ['pink', 'blue', 'yellow', 'purple'];

        $managedClasses = DB::table('classes')
            ->select(
                'classes.classname as name',
                'classes.code as code',
                DB::raw("'You' as creator"),
                DB::raw("'admin' as role")
            )
            ->where('creator_id', $currentUserId)
            ->get();
            
        $yourClasses = DB::table('classmembers')
            ->join('classes', 'classmembers.code', '=', 'classes.code')
            ->join('useraccount', 'classes.creator_id', '=', 'useraccount.user_id')
            ->select(
                'classes.classname as name',
                'classes.code as code',
                DB::raw("CONCAT(useraccount.firstname, ' ', useraccount.lastname) as creator"),
                'classmembers.role as role'
            )
            ->where('classmembers.user_id', $currentUserId)
            ->where('classes.creator_id', '!=', $currentUserId)
            ->get();
            
        $classIds = $managedClasses->pluck('code')->merge($yourClasses->pluck('code'))->unique()->toArray();
        
        $recentPostsRaw = DB::table('posts')
            ->join('classes', 'posts.code', '=', 'classes.code')
            ->select(
                'posts.post_id',
                'posts.code',
                'posts.content',
                'posts.post_type',
                'posts.created_at',
                'classes.classname as class_name'
            )
            ->whereIn('posts.code', $classIds)
            ->whereIn('posts.post_type', ['announcement'])
            ->orderBy('posts.created_at', 'desc') 
            ->limit(3)
            ->get();

        $recentPosts = $recentPostsRaw->map(function ($post, $key) use ($pastelColors) {
            $color = $pastelColors[$key % count($pastelColors)];
            $post->color_prefix = $color;
            return $post;
        });

        $classData = $managedClasses->merge($yourClasses);
        
        $allClasses = $classData->map(function ($class, $key) use ($pastelColors) {
            $memberCount = DB::table('classmembers')->where('code', $class->code)->count() + 1;

            $color = $pastelColors[$key % count($pastelColors)];

            return [
                'creator' => $class->creator,
                'name' => $class->name,
                'count' => str_pad($memberCount, 2, '0', STR_PAD_LEFT), 
                'color' => $color,
                'role' => $class->role,
            ];
        })->values()->all();

        return view('dashboard', [
            'userFirstName' => $userFirstName, 
            'recentPosts' => $recentPosts,
            'allClasses' => $allClasses,
        ]);
    }
}