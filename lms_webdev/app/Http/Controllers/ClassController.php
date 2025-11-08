<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\ClassMember;
use App\Models\PinnedClassesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $pinnedClassCodes = PinnedClassesModel::where('user_id', $userId)
            ->pluck('class_code')
            ->toArray();

        $pinnedClassesDetails = ClassModel::whereIn('code', $pinnedClassCodes)
            ->with('creator') 
            ->get();

        $yourClasses = DB::table('classmembers')
            ->join('classes', 'classmembers.code', '=', 'classes.code') 
            ->leftJoin('useraccount', 'classes.creator_id', '=', 'useraccount.user_id')
            ->where('classmembers.user_id', $userId)
            ->select(
                'classes.code',
                'classes.classname',
                'classes.color',
                DB::raw('COALESCE(useraccount.name, "Unknown") as creator_name'),
                DB::raw('(SELECT COUNT(*) FROM posts WHERE posts.class_code = classes.code) as post_count')
            )
            ->get();

        // 4. Pass data to the view
        return view('classes', compact('pinnedClassesDetails', 'yourClasses'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_name' => 'required|string',
            'description' => 'nullable|string',
            'color'=> 'nullable|string',
        ]);

        return ClassModel::create($validated);
    }
    public function join(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|exists:classes,code', 
        ]);

        $userId = Auth::id();

        $exists = ClassMember::where('code', $validated['code'])
                            ->where('user_id', $userId)
                            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'You are already a member of this class.');
        }

        ClassMember::create([
            'code' => $validated['code'],
            'user_id' => $userId,
        ]);

        return redirect()->back()->with('success', 'Successfully joined the class!');
    }
}
