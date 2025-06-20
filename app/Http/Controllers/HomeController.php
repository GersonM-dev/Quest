<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leaderboard;
use App\Models\User;

class HomeController extends Controller
{
    public function dashboard()
    {
        $userId = auth()->id();
        $myPoint = Leaderboard::where('user_id', $userId)->value('score') ?? 0;

        // Get top 5 users for leaderboard bar chart
        $leaderboard = Leaderboard::with('user')
            ->orderByDesc('score')
            ->take(5)
            ->get()
            ->map(function($row) {
                return [
                    'name' => $row->user->name,
                    'score' => $row->score
                ];
            });

        return view('dashboard', compact('myPoint', 'leaderboard'));
    }
}
