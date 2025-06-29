<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MateriController extends Controller
{
    public function index()
    {
        $materis = \App\Models\Materi::orderByDesc('date')->get();
        return view('materi.index', compact('materis'));
    }

    public function view($id)
    {
        $materi = \App\Models\Materi::findOrFail($id);

        // Track per-user daily view time (in session, or use DB for full production)
        $user = auth()->user();
        $dateKey = 'pdf_timer_' . $user->id . '_' . date('Ymd') . '_' . $materi->id;

        // Default to 30 minutes (1800 seconds)
        $remaining = 1800 - (session($dateKey, 0));

        // If time is up, redirect or block
        if ($remaining <= 0) {
            return view('materi.blocked', compact('materi'));
        }

        return view('materi.viewer', compact('materi', 'remaining'));
    }

    public function timer(Request $request, $id)
    {
        $user = auth()->user();
        $dateKey = 'pdf_timer_' . $user->id . '_' . date('Ymd') . '_' . $id;
        session([$dateKey => session($dateKey, 0) + 10]); // Add 10 seconds each tick
        return response()->noContent();
    }



}
