<?php

namespace App\Http\Controllers;

use App\Models\PinnedClassesModel;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinnedClassesController extends Controller
{

    public function index()
    {
        $userId = Auth::id();

        $pinnedClassesRecords = PinnedClassesModel::where('user_id', $userId)->get();

        $classCodes = $pinnedClassesRecords->pluck('code')->toArray();

        $pinnedClassesDetails = ClassModel::whereIn('code', $classCodes)
            ->get(); 
        
        return view('classes', compact('pinnedClassesDetails'));
    }
    
    public function togglePin(Request $request, $code)
    {
        $class = ClassModel::where('code', $code)->firstOrFail(); 
        
        $userId = Auth::id();

        $pin = PinnedClassesModel::where('user_id', $userId)
            ->where('code', $code)
            ->first();

        if ($pin) {
            $pin->delete();
            $message = 'Class unpinned.';
        } else {
            PinnedClassesModel::create([
                'user_id' => $userId,
                'code' => $code,
                'is_pinned' => 1,
            ]);
            $message = 'Class pinned!';
        }

        return response()->json([
            'message' => $message,
            'is_pinned' => (bool)!$pin
        ]);
    }
}