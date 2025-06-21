<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class LeaderBoard extends ChartWidget
{
    protected static ?string $heading = 'Leaderboard Top 10';

    protected function getData(): array
    {
        $leaders = \App\Models\Leaderboard::with('user')
            ->orderByDesc('score')
            ->take(10)
            ->get();

        $labels = $leaders->map(fn($l) => $l->user->name ?? "User " . $l->user_id)->toArray();
        $scores = $leaders->pluck('score')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Score',
                    'data' => $scores,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

}
