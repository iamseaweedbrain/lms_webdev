<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubmissionModel;
use App\Models\ClassModel;
use App\Models\ClassMember; 
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
        $colors = ['blue', 'pink', 'yellow', 'purple'];
        
        // Get mode (student or teacher)
        $mode = request()->query('view', 'student');

        // --- Fetching and Filtering Classes based on Mode ---
        
        // 1. Get all classes the user is associated with, along with their role
        $allClassMemberships = ClassMember::with('class')
            ->where('user_id', $userId)
            ->get();

        // 2. Filter memberships based on the requested view mode
        $filteredMemberships = $allClassMemberships->filter(function($cm) use ($mode) {
            if ($mode === 'teacher') {
                // In teacher mode, only show classes where the user is admin or co-admin
                return in_array($cm->role, ['admin', 'co-admin']);
            }
            // In student mode, only show classes where the user is a member
            return $cm->role === 'member'; 
        });

        // 3. Map the filtered collection to the final $allClasses array for the view
        $allClasses = $filteredMemberships->values()->map(function($cm, $index) use ($colors) {
            return [
                'id' => $cm->class->id,
                'classname' => $cm->class->classname,
                'code' => $cm->class->code ?? null,
                'color' => $colors[$index % count($colors)],
                'role' => $cm->role ?? 'member', // e.g. admin = teacher
            ];
        });

        // Determine which class is selected (from the FILTERED list)
        $selectedClassId = request('class') 
            ?? session()->get('last_selected_class') 
            ?? ($allClasses->first()['id'] ?? null);

        $selectedClass = $allClasses->firstWhere('id', $selectedClassId);

        // --- Submissions/Assignments Query ---

        // Build query for submissions
        $query = SubmissionModel::with('post');

        if ($selectedClass) {
            $code = $selectedClass['code'];

            // 1. Filter by class code (common to both modes)
            $query->whereHas('post', fn($q) => $q->where('code', $code));
            
            // 2. Apply user filter ONLY if in student mode
            if ($mode === 'student') {
                // Students see only their own submissions for assignments in that class
                $query->where('user_id', $userId);
            }
        }

        // --- Pagination Setup and Execution ---
        
        // Initialize pagination variables with safe defaults
        $perPage = 10;
        $currentPage = max(1, (int) request('page', 1));
        $pageCount = 0;
        $submissions = collect();

        if ($selectedClass) {
            // Pagination calculation
            // Use clone for count query to avoid resetting the offset/limit on the main query
            $total = (clone $query)->count(); 
            $pageCount = (int) ceil($total / $perPage);
    
            $submissions = $query
                ->skip(($currentPage - 1) * $perPage)
                ->take($perPage)
                ->get();
        } 


        // Map submissions to assignment display
        $assignments = $submissions->map(function($sub) use ($mode) {
            return [
                'submission_id' => $sub->submission_id,
                'name' => $sub->post->post_title ?? 'Assignment',
                'score' => $sub->score, 
                'feedback' => $sub->feedback,
                'route' => $mode === 'teacher'
                    ? route('grades_check', ['id' => $sub->submission_id]) // Teacher Check
                    : route('student_grade', ['id' => $sub->submission_id]), // Student View
            ];
        });

        // --- Recent Classes ---
        if ($mode === 'teacher') {
            // Teacher mode: get classes they created
            $recentClasses = ClassModel::where('creator_id', $userId)
                ->latest()
                ->take(5)
                ->get();
        } else {
            // Student mode: get classes they are a member of (most recently joined)
            $recentClasses = ClassMember::with('class')
                ->where('user_id', $userId)
                ->orderBy('joined_at', 'desc') 
                ->take(5)
                ->get()
                ->map(fn($cm) => $cm->class);
        }

        // Save selected class in session (using the ID from the filtered list)
        session()->put('last_selected_class', $selectedClassId);

        // Return to the same Blade
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

    /**
     * Extracts the data for a single submission view.
     * @param string $id Submission ID
     * @return array
     */
    private function getSubmissionData(string $id): array
    {
        // Eager load post and the user who submitted the assignment (student)
        $submission = SubmissionModel::with(['post.user', 'user'])->findOrFail($id);
        
        $post = $submission->post;
        
        // The blade uses $creatorName for the submitter's name (the student)
        $studentName = $submission->user ? 
                       ($submission->user->firstname . ' ' . $submission->user->lastname) : 
                       'Student';

        $assignmentName = $post->post_title ?? $post->content ?? 'Assignment';
        $createdDate = $post->created_at ? date('M d, Y', strtotime($post->created_at)) : null;

        $dateSubmitted = $submission->submitted_at ? date('M d, Y H:i', strtotime($submission->submitted_at)) : 'Not Submitted';
        $filePath = $submission->file_path ?? null;
        $fileFormat = $submission->file_type ?? '';
        $feedback = $submission->feedback ?? '';
        
        // Pass the raw score/null for the input field value
        $rawScore = $submission->score !== null ? $submission->score : null; 

        return [
            'submissionId' => $submission->submission_id,
            'creatorName' => $studentName,
            'assignmentName' => $assignmentName,
            'createdDate' => $createdDate,
            'dateSubmitted' => $dateSubmitted,
            'filePath' => $filePath,
            'fileFormat' => $fileFormat,
            'score' => $rawScore, // Raw score for the input field
            'feedback' => $feedback,
        ];
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
                    'submitted_at' => now(), 
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
        // Use Auth::user() to get the name of the teacher grading it
        $teacherName = Auth::user() ? (Auth::user()->firstname . ' ' . Auth::user()->lastname) : 'Grader';

        $submission = SubmissionModel::findOrFail($id);
        $submission->update([
            'score' => $request->score,
            'feedback' => $request->feedback,
            'graded_by' => $teacherName, // Use the actual authenticated user's name
            'graded_at' => now(),
        ]);

        return response()->json(['message' => 'Submission graded']);
    }

    /**
     * Handles the standard resource show route. (Default view for student)
     */
    public function show(string $id)
    {
        $data = $this->getSubmissionData($id);
        // Assuming 'grades_view' is the student's read-only view
        return view('grades_view', $data); 
    }
    
    /**
     * Handles the 'grades_check' route (Teacher view for grading).
     */
    // Show a submission for grading
    public function gradesCheck($submissionId)
    {
        // Fetch submission with student info
        $submission = SubmissionModel::with('student', 'assignment')->findOrFail($submissionId);

        // Check if a grade already exists for this submission
        $existingGrade = SubmissionModel::where('submission_id', $submissionId)->first();

        return view('grades_check', [
            'submissionId'   => $submission->id,
            'creatorName'    => $submission->student->name ?? 'Student Name',
            'assignmentName' => $submission->assignment->title ?? 'Assignment Name',
            'createdDate'    => $submission->created_at->format('M d, Y'),
            'dateSubmitted'  => $submission->submitted_at?->format('M d, Y H:i') ?? 'Not submitted',
            'filePath'       => $submission->file_path ?? null,
            'fileFormat'     => pathinfo($submission->file_path ?? '', PATHINFO_EXTENSION) ?: 'File',
            'score'          => $existingGrade->score ?? '',
            'feedback'       => $existingGrade->feedback ?? '',
        ]);
    }

    // Save grade
    public function saveGrade(Request $request, $submissionId)
    {
        $validated = $request->validate([
            'score'     => 'required|numeric|min:0|max:100',
            'feedback'  => 'nullable|string|max:2000',
            'graded_by' => 'required|string|max:255',
        ]);

        $grade = Grade::updateOrCreate(
            ['submission_id' => $submissionId],
            [
                'score'     => $validated['score'],
                'feedback'  => $validated['feedback'],
                'graded_by' => $validated['graded_by'],
            ]
        );

        return response()->json(['message' => 'Grade submitted successfully!']);
    }
    /**
     * Handles the 'student_grade' route (Student view, likely read-only).
     */
    public function showStudentGrade(string $id)
    {
        $data = $this->getSubmissionData($id);
        // Assuming 'grades_view' is the student's read-only view
        return view('grades_view', $data); 
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