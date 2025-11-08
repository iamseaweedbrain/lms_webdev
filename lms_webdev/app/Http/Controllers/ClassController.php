<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\ClassMember;
use App\Models\PinnedClassesModel;
use App\Models\PostReadModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $pinnedClassCodes = PinnedClassesModel::where('user_id', $userId)
            ->pluck('code')
            ->toArray();

        $pinnedClassesDetails = ClassModel::whereIn('code', $pinnedClassCodes)
            ->with('creator')
            ->get()
            ->map(function ($class) use ($userId) {
                // Get the user's role in this class
                $membership = ClassMember::where('code', $class->code)
                    ->where('user_id', $userId)
                    ->first();

                // If no membership, check if user is the creator
                if ($membership) {
                    $class->user_role = $membership->role;
                } else if ($class->creator_id === $userId) {
                    $class->user_role = 'admin';
                } else {
                    $class->user_role = 'member';
                }

                // Get pending assignments count (assignments without submissions from this user)
                $class->pending_count = DB::table('posts')
                    ->where('code', $class->code)
                    ->where('post_type', 'assignment')
                    ->whereNotExists(function ($query) use ($userId) {
                        $query->select(DB::raw(1))
                            ->from('submissions')
                            ->whereColumn('submissions.post_id', 'posts.post_id')
                            ->where('submissions.user_id', $userId);
                    })
                    ->count();

                return $class;
            });

        // Get classes where user is a member
        $memberClasses = DB::table('classmembers')
            ->join('classes', 'classmembers.code', '=', 'classes.code')
            ->leftJoin('useraccount', 'classes.creator_id', '=', 'useraccount.user_id')
            ->where('classmembers.user_id', $userId)
            ->select(
                'classes.code',
                'classes.classname',
                'classes.color',
                'classes.creator_id',
                'classes.created_at',
                'classmembers.role as user_role',
                DB::raw('COALESCE(CONCAT(useraccount.firstname, " ", useraccount.lastname), "Unknown") as creator_name'),
                DB::raw('(SELECT COUNT(*) FROM posts WHERE posts.code = classes.code) as post_count'),
                DB::raw('(SELECT CONCAT(post_type, " posted ", DATE_FORMAT(created_at, "%b %d")) FROM posts WHERE posts.code = classes.code ORDER BY created_at DESC LIMIT 1) as latest_update')
            )
            ->get()
            ->map(function ($class) use ($userId) {
                // Override role to admin if user is the creator AND current role is not 'member'
                // This allows creators to still see their class in student mode if they joined as a member
                if ($class->creator_id === $userId && $class->user_role !== 'member') {
                    $class->user_role = 'admin';
                }
                return $class;
            });

        // Get classes where user is the creator (in case they don't have a classmember entry)
        $createdClasses = DB::table('classes')
            ->leftJoin('useraccount', 'classes.creator_id', '=', 'useraccount.user_id')
            ->where('classes.creator_id', $userId)
            ->whereNotIn('classes.code', $memberClasses->pluck('code'))
            ->select(
                'classes.code',
                'classes.classname',
                'classes.color',
                'classes.created_at',
                DB::raw("'admin' as user_role"),
                DB::raw('COALESCE(CONCAT(useraccount.firstname, " ", useraccount.lastname), "You") as creator_name'),
                DB::raw('(SELECT COUNT(*) FROM posts WHERE posts.code = classes.code) as post_count'),
                DB::raw('(SELECT CONCAT(post_type, " posted ", DATE_FORMAT(created_at, "%b %d")) FROM posts WHERE posts.code = classes.code ORDER BY created_at DESC LIMIT 1) as latest_update')
            )
            ->get();

        // Merge both collections
        $yourClasses = $memberClasses->merge($createdClasses);

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

        $creatorId = Auth::id();

        $allowedColors = ['pink', 'blue', 'purple', 'yellow'];
        $color = in_array($validated['color'] ?? '', $allowedColors) ? $validated['color'] : 'pink';

        do {
            $code = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        } while (ClassModel::where('code', $code)->exists());

        $class = ClassModel::create([
            'creator_id' => $creatorId,
            'classname' => $validated['class_name'],
            'description' => $validated['description'] ?? null,
            'code' => $code,
            'color' => $color,
        ]);

        try {
            ClassMember::create([
                'code' => $code,
                'user_id' => $creatorId,
                'role' => 'admin',
            ]);
        } catch (\Exception $e) {

        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($class, 201);
        }

        return redirect()->route('dashboard')->with('success', 'Class created successfully.');
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
            // Already a member, just redirect to classes page in student mode
            return redirect()->route('classes')->with('info', 'You are already a member of this class. Make sure you are in Student mode to see it.');
        }

        ClassMember::create([
            'code' => $validated['code'],
            'user_id' => $userId,
            'role' => 'member',
        ]);

        return redirect()->route('classes')->with('success', 'Successfully joined the class!');
    }

    public function show($code)
    {
        $userId = Auth::id();

        // Get the class details
        $class = ClassModel::where('code', $code)
            ->with('creator')
            ->firstOrFail();

        // Check if user is a member of this class
        $membership = ClassMember::where('code', $code)
            ->where('user_id', $userId)
            ->first();

        // If no membership but user is the creator, create a virtual membership
        if (!$membership && $class->creator_id === $userId) {
            $membership = (object) [
                'code' => $code,
                'user_id' => $userId,
                'role' => 'admin'
            ];
        }

        // If still no membership, user is not authorized
        if (!$membership) {
            abort(403, 'You are not a member of this class.');
        }

        // Get all posts for this class (announcements and materials)
        $posts = DB::table('posts')
            ->leftJoin('useraccount', 'posts.user_id', '=', 'useraccount.user_id')
            ->where('posts.code', $code)
            ->whereIn('posts.post_type', ['announcement', 'material'])
            ->select(
                'posts.*',
                DB::raw('COALESCE(CONCAT(useraccount.firstname, " ", useraccount.lastname), "Unknown") as author_name')
            )
            ->orderBy('posts.created_at', 'desc')
            ->get();

        // Get all assignments for this class
        $assignments = DB::table('posts')
            ->leftJoin('useraccount', 'posts.user_id', '=', 'useraccount.user_id')
            ->where('posts.code', $code)
            ->where('posts.post_type', 'assignment')
            ->select(
                'posts.*',
                DB::raw('COALESCE(CONCAT(useraccount.firstname, " ", useraccount.lastname), "Unknown") as author_name')
            )
            ->orderBy('posts.due_date', 'asc')
            ->get();

        // Get submission data for assignments (for current user)
        $submissions = DB::table('submissions')
            ->whereIn('post_id', $assignments->pluck('post_id')->toArray())
            ->where('user_id', $userId)
            ->select('post_id', 'file_path', 'file_type', 'submitted_at')
            ->get()
            ->keyBy('post_id');

        // Get class members with full profile information
        $members = DB::table('classmembers')
            ->join('useraccount', 'classmembers.user_id', '=', 'useraccount.user_id')
            ->where('classmembers.code', $code)
            ->select(
                'useraccount.user_id',
                'useraccount.firstname',
                'useraccount.lastname',
                DB::raw('CONCAT(useraccount.firstname, " ", useraccount.lastname) as name'),
                'useraccount.email',
                'useraccount.avatar',
                'useraccount.created_at as member_since',
                'classmembers.role'
            )
            ->get();

        // Get read status for all posts and assignments
        $readPostIds = PostReadModel::where('user_id', $userId)
            ->whereIn('post_id', array_merge($posts->pluck('post_id')->toArray(), $assignments->pluck('post_id')->toArray()))
            ->pluck('post_id')
            ->toArray();

        return view('class-view', compact('class', 'membership', 'posts', 'assignments', 'members', 'readPostIds', 'submissions'));
    }

    public function leave($code)
    {
        $userId = Auth::id();

        // Check if user is a member of this class
        $membership = ClassMember::where('code', $code)
            ->where('user_id', $userId)
            ->first();

        if (!$membership) {
            return redirect()->route('classes')->with('error', 'You are not a member of this class.');
        }

        // Prevent admin/creator from leaving their own class
        if ($membership->role === 'admin') {
            return redirect()->route('classes')->with('error', 'Class creators cannot leave their own class. Please delete the class instead.');
        }

        // Delete the membership
        $membership->delete();

        // Also unpin if pinned
        PinnedClassesModel::where('user_id', $userId)
            ->where('code', $code)
            ->delete();

        return redirect()->route('classes')->with('success', 'You have successfully left the class.');
    }

    public function delete($code)
    {
        $userId = Auth::id();

        // Check if user is admin of this class
        $membership = ClassMember::where('code', $code)
            ->where('user_id', $userId)
            ->first();

        if (!$membership || ($membership->role !== 'admin' && $membership->role !== 'coadmin')) {
            return redirect()->route('classes')->with('error', 'You do not have permission to delete this class.');
        }

        // Only the creator (admin) can delete the class
        if ($membership->role !== 'admin') {
            return redirect()->route('classes')->with('error', 'Only the class creator can delete the class.');
        }

        // Get the class
        $class = ClassModel::where('code', $code)->first();

        if (!$class) {
            return redirect()->route('classes')->with('error', 'Class not found.');
        }

        // Delete the class (cascade will handle related records)
        $class->delete();

        return redirect()->route('classes')->with('success', 'Class deleted successfully.');
    }
}
