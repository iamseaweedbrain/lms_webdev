<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubmissionModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $userId = $user->user_id;

        $joinedClassMembers = \App\Models\ClassMember::with('class')
            ->where('user_id', $userId)
            ->get();
        $allClasses = $joinedClassMembers
            ->filter(fn($cm) => $cm->class && $cm->class->creator_id !== $userId)
            ->map(function($cm, $index) {
                $colors = ['blue', 'pink', 'yellow', 'purple'];
                return [
                    'id' => $cm->class->id,
                    'classname' => $cm->class->classname,
                    'color' => $colors[$index % count($colors)],
                ];
            })->values();

        $requestedClassId = request('class');

        $recentIds = session()->get('recent_classes', []);

        if ($requestedClassId) {
            $recentIds = array_values(array_filter($recentIds, fn($id) => (string)$id !== (string)$requestedClassId));
            array_unshift($recentIds, $requestedClassId);
            $recentIds = array_slice($recentIds, 0, 4);
            session()->put('recent_classes', $recentIds);
            session()->put('last_selected_class', $requestedClassId);
        }

        $selectedClassId = $requestedClassId ?? session()->get('last_selected_class') ?? ($allClasses->first()['id'] ?? null);
        $selectedClass = $allClasses->firstWhere('id', $selectedClassId);

        $recentClasses = collect();
        foreach (session()->get('recent_classes', []) as $id) {
            $c = $allClasses->firstWhere('id', $id);
            if ($c) {
                $recentClasses->push($c);
            }
        }
        if ($recentClasses->count() < 4) {
            $fill = $allClasses->reject(fn($c) => $recentClasses->firstWhere('id', $c['id']))->take(4 - $recentClasses->count());
            $recentClasses = $recentClasses->concat($fill)->values();
        }

        $assignments = collect();
        $pageCount = 1;
        $currentPage = max(1, (int)request('page', 1));
        $perPage = 10;
        if ($selectedClassId) {
            $query = \App\Models\SubmissionModel::with(['post'])
                ->where('user_id', $userId)
                ->whereHas('post', function($q) use ($selectedClassId) {
                    $q->where('class_id', $selectedClassId);
                });
            $total = $query->count();
            $pageCount = (int) ceil($total / $perPage);
            $submissions = $query->skip(($currentPage-1)*$perPage)->take($perPage)->get();
            $assignments = $submissions->map(function($sub) {
                return [
                    'submission_id' => $sub->submission_id,
                    'name' => $sub->post->content ?? 'Assignment',
                    'score' => $sub->score,
                    'feedback' => $sub->feedback,
                ];
            });
        }

        return view('grades', [
            'recentClasses' => $recentClasses,
            'allClasses' => $allClasses,
            'selectedClass' => $selectedClass,
            'assignments' => $assignments,
            'pageCount' => $pageCount,
            'currentPage' => $currentPage,
        ]);
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
        try {
            $validated = $request->validate([
                'post_id' => 'required|exists:posts,post_id',
                'assignment_file' => 'required|file|max:10240', // Max 10MB
            ]);

            $userId = Auth::id();

            // Handle file upload
            if ($request->hasFile('assignment_file')) {
                $file = $request->file('assignment_file');
                $fileName = time() . '_' . $userId . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('submissions', $fileName, 'public');

                // Determine file type
                $mimeType = $file->getMimeType();
                $fileType = 'file'; // default
                if (str_starts_with($mimeType, 'image/')) {
                    $fileType = 'image';
                }

                // Create submission record
                $submission = SubmissionModel::create([
                    'post_id' => $validated['post_id'],
                    'user_id' => $userId,
                    'file_type' => $fileType,
                    'file_path' => $filePath,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Assignment submitted successfully',
                    'submission' => $submission
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded'
            ], 400);

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
        return view('students_grade', ['id' => $id]);
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
