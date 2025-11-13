<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubmissionModel;
use App\Models\ClassModel;
use App\Models\ClassMember;
use Illuminate\Support\Facades\Auth; // Added ClassMember model for clarity

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $userId = $user->user_id;
        $colors = ['blue', 'pink', 'yellow', 'purple'];
        
        $mode = request()->query('view', 'student');

        $allClassMemberships = ClassMember::with('class')
            ->where('user_id', $userId)
            ->get();

        $filteredMemberships = $allClassMemberships->filter(function($cm) use ($mode) {
            if ($mode === 'teacher') {
                return in_array($cm->role, ['admin', 'co-admin']);
            }
            return $cm->role === 'member'; 
        });

        $allClasses = $filteredMemberships->values()->map(function($cm, $index) use ($colors) {
            return [
                'id' => $cm->class->id,
                'classname' => $cm->class->classname,
                'code' => $cm->class->code ?? null,
                'color' => $colors[$index % count($colors)],
                'role' => $cm->role ?? 'member',
            ];
        });

        $selectedClassId = request('class') 
            ?? session()->get('last_selected_class') 
            ?? ($allClasses->first()['id'] ?? null);

        $selectedClass = $allClasses->firstWhere('id', $selectedClassId);

        $query = SubmissionModel::with('post');

        if ($selectedClass) {
            $code = $selectedClass['code'];

            $query->whereHas('post', fn($q) => $q->where('code', $code));
            
            if ($mode === 'student') {
                $query->where('user_id', $userId);
            }
        }

        $perPage = 10;
        $currentPage = max(1, (int) request('page', 1));
        $pageCount = 0;
        $submissions = collect();

        if ($selectedClass) {
            $total = (clone $query)->count(); 
            $pageCount = (int) ceil($total / $perPage);
    
            $submissions = $query
                ->skip(($currentPage - 1) * $perPage)
                ->take($perPage)
                ->get();
        } 

        $assignments = $submissions->map(function($sub) use ($mode) {
            return [
                'submission_id' => $sub->submission_id,
                'name' => $sub->post->post_title ?? 'Assignment',
                'score' => $sub->score, 
                'feedback' => $sub->feedback,
                'route' => $mode === 'teacher'
                    ? route('grades_check', ['submissionId' => $sub->submission_id]) 
                    : route('student_grade', ['id' => $sub->submission_id]),
            ];
        });

        if ($mode === 'teacher') {
            $recentClasses = ClassModel::where('creator_id', $userId)
                ->latest()
                ->take(5)
                ->get();
        } else {
            $recentClasses = ClassMember::with('class')
                ->where('user_id', $userId)
                ->orderBy('joined_at', 'desc') 
                ->take(5)
                ->get()
                ->map(fn($cm) => $cm->class);
        }

        session()->put('last_selected_class', $selectedClassId);

        return view('grades', compact(
            'allClasses',
            'selectedClass',
            'assignments',
            'pageCount',
            'currentPage', 
            'recentClasses',
            'mode'
        ));
    }

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
                    'submitted_at' => now(), // added submitted_at for consistency
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
     * Extracts the logic for displaying a single submission.
     * @param string $id Submission ID
     * @return \Illuminate\View\View
     */
    private function getSubmissionDetails(string $id)
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
    public function show(string $id)
    {
        return $this->getSubmissionDetails($id);
    }
    public function gradesCheck($submissionId)
    {
        $submission = SubmissionModel::with('student', 'post', 'grader')->findOrFail($submissionId);

        return view('grades_check', [
            'submissionId' => $submission->submission_id,
            'creatorName'  => $submission->student->firstname . ' ' . $submission->student->lastname,
            'assignmentName' => $submission->post->post_title ?? 'Assignment',
            'dateSubmitted'  => $submission->submitted_at ?? 'Not submitted',
            'filePath'       => $submission->file_path,
            'fileFormat'     => $submission->file_type ?? 'File',
            'score'          => $submission->score,
            'feedback'       => $submission->feedback,
        ]);
    }

    public function saveGrade(Request $request, $submissionId)
    {
        $validated = $request->validate([
            'score'     => 'required|numeric|min:0|max:100',
            'feedback'  => 'nullable|string|max:2000',
            'graded_by' => 'required|string|max:255',
        ]);

        $submission = SubmissionModel::findOrFail($submissionId);

        $submission->update([
            'score'     => $validated['score'],
            'feedback'  => $validated['feedback'],
            'graded_by' => Auth::id(),
            'graded_at' => now(),
        ]);

        return response()->json(['message' => 'Grade submitted successfully!']);
    }
    public function showStudentGrade(string $id)
    {
        return $this->getSubmissionDetails($id);
    }

}