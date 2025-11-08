<?php

namespace App\Http\Controllers;

use App\Models\NotificationModel;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = [
            [
                'title' => 'New Assignment: WEB SYSTEM AND TECHNOLOGIES 2',
                'date' => 'Posted: Nov 8, 2025',
                'icon' => 'mdi:book-open-variant',
                'bgColor' => '#F9CADA',
                'url' => '/grades-overview'
            ],
            [
                'title' => 'Class Announcement: ALGORITHM AND COMPLEXITY',
                'date' => 'Posted: Nov 7, 2025',
                'icon' => 'mdi:bullhorn-outline',
                'bgColor' => '#D9CCF1',
                'url' => '/announcements'
            ],
            // add other notifications
        ];

        return view('notification', compact('notifications'));
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
        //
    }

    public function markAsRead($id)
    {
        $notif = NotificationModel::findOrFail($id);
        $notif->update(['is_read' => 1]);

        return response()->json(['message' => 'Notification marked as read']);
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
