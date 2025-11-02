<?php

namespace App\Http\Controllers;

use App\Models\SubmissionModel;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'post_id' => 'required|exists:posts,post_id',
            'user_id' => 'required|exists:user_accounts,user_id',
            'file_type' => 'required|in:image,file,link',
            'file_path' => 'required|string',
        ]);

        return SubmissionModel::create($validated);
    }

    public function grade(Request $request, $id)
    {
        $submission = SubmissionModel::findOrFail($id);
        $submission->update([
            'score' => $request->score,
            'feedback' => $request->feedback,
            'graded_by' => $request->graded_by,
            'graded_at' => now(),
        ]);

        return response()->json(['message' => 'Submission graded']);
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
}
