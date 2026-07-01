<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_recordings' => auth()->user()->recordings()->count(),
            'total_transcripts' => auth()->user()->recordings()->whereHas('transcript')->count(),
            'total_duration' => auth()->user()->recordings()->sum('duration') ?? 0,
            'activity_this_week' => auth()->user()->recordings()->where('created_at', '>=', now()->subWeek())->count(),
        ];

        $recentRecordings = auth()->user()->recordings()
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentRecordings'));
    }
}
