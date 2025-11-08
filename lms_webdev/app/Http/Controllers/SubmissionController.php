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
                    'code' => $cm->class->code ?? null,
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
            // posts are linked to classes by 'code' (see posts migration). Find the code for the selected class id.
            $selectedClassRecord = $allClasses->firstWhere('id', $selectedClassId);
            $selectedClassCode = $selectedClassRecord['code'] ?? null;

            $query = \App\Models\SubmissionModel::with(['post'])
                ->where('user_id', $userId)
                ->whereHas('post', function($q) use ($selectedClassCode) {
                    if ($selectedClassCode) {
                        $q->where('code', $selectedClassCode);
                    }
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
        $submission = SubmissionModel::with(['post.user'])->findOrFail($id);

        $post = $submission->post;
        $creatorName = $post && $post->user ? ($post->user->firstname . ' ' . $post->user->lastname) : 'Instructor';
        $assignmentName = $post->post_title ?? $post->content ?? 'Assignment';
        $createdDate = $post->created_at ?? null;
        if ($createdDate) {
            try {
                $createdDate = date('M d, Y', strtotime($createdDate));
            } catch (\Exception $e) {
                $createdDate = null;
            }
        }

        $dateSubmitted = $submission->submitted_at ? date('M d, Y H:i', strtotime($submission->submitted_at)) : '—';
        $filePath = $submission->file_path ?? 'No file';
        $fileFormat = $submission->file_type ?? '';
        $feedback = $submission->feedback ?? 'No feedback yet.';
        $grade = $submission->score !== null ? $submission->score : '—';
        $score = ($submission->score !== null && $post && $post->max_score) ? ($submission->score . ' / ' . $post->max_score) : ($submission->score ?? '—');

        return view('grades_view', [
            'creatorName' => $creatorName,
            'assignmentName' => $assignmentName,
            'createdDate' => $createdDate,
            'dateSubmitted' => $dateSubmitted,
            'filePath' => $filePath,
            'fileFormat' => $fileFormat,
            'feedback' => $feedback,
            'grade' => $grade,
            'score' => $score,
        ]);
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
