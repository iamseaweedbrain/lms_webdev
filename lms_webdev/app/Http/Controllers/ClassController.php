<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\ClassMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ClassModel::with('classes')->get();
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
            'class_name' => 'required|string',
            'description' => 'nullable|string',
            'color'=> 'nullable|string',
        ]);

        return ClassModel::create($validated);
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
        //
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
