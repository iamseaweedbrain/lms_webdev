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
                'classes.id as class_id',
                DB::raw("'You' as creator"),
                DB::raw("'admin' as role")
            )
            ->where('creator_id', $currentUserId)
            ->get();
            
        $yourClasses = DB::table('classmembers')
            ->join('classes', 'classmembers.class_id', '=', 'classes.id')
            ->join('useraccount', 'classes.creator_id', '=', 'useraccount.user_id')
            ->select(
                'classes.classname as name',
                'classes.id as class_id',
                DB::raw("CONCAT(useraccount.firstname, ' ', useraccount.lastname) as creator"),
                'classmembers.role as role'
            )
            ->where('classmembers.user_id', $currentUserId)
            ->where('classes.creator_id', '!=', $currentUserId)
            ->get();
            
        $classIds = $managedClasses->pluck('class_id')->merge($yourClasses->pluck('class_id'))->unique()->toArray();
        
        $recentPostsRaw = DB::table('posts')
            ->join('classes', 'posts.class_id', '=', 'classes.id')
            ->select(
                'posts.post_id',
                'posts.class_id',
                'posts.content',
                'posts.post_type',
                'posts.created_at',
                'classes.classname as class_name'
            )
            ->whereIn('posts.class_id', $classIds)
            ->whereIn('posts.post_type', ['material', 'assignment', 'announcement'])
            ->orderBy('posts.created_at', 'desc') 
            ->limit(3)
            ->get();

        $recentPosts = $recentPostsRaw->map(function ($post) use ($pastelColors) {
            $post->color_prefix = $pastelColors[$post->class_id % count($pastelColors)];
            return $post;
        });

        $classData = $managedClasses->merge($yourClasses);
        
        $allClasses = $classData->map(function ($class) use ($pastelColors) {
            $memberCount = DB::table('classmembers')->where('class_id', $class->class_id)->count() + 1;

            $color = $pastelColors[$class->class_id % count($pastelColors)];

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