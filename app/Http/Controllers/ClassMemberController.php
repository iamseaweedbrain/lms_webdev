<?php

namespace App\Http\Controllers;

use App\Models\ClassMember;
use Illuminate\Http\Request;

class ClassMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ClassMember::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'user_id' => 'required|exists:useraccount,user_id',
            'role' => 'nullable|in:member,coadmin,admin',
        ]);

        $class = \App\Models\ClassModel::find($validated['class_id']);

        if ($validated['user_id'] == $class->creator_id) {
            $validated['role'] = 'admin';
        } else {
            $validated['role'] = $validated['role'] ?? 'member';
        }

        return ClassMember::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = ClassMember::findOrFail($id);
        $member->delete();

        return response()->json(['message' => 'Member removed']);
    }
}
