@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-6 text-center">Hai {{ Auth::user()->name }}</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

            {{-- Daily Quest --}}
            <a href="{{ route('quiz.choose-level') }}"
                class="block bg-white rounded-xl shadow hover:shadow-lg transition p-6 text-center group border border-blue-200">
                <div
                    class="mx-auto w-14 h-14 flex items-center justify-center bg-blue-100 rounded-full mb-4 group-hover:bg-blue-200">
                    <svg class="w-7 h-7 text-blue-600 group-hover:text-blue-800" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"></path>
                        <circle cx="12" cy="12" r="10"></circle>
                    </svg>
                </div>
                <div class="font-semibold text-lg mb-1 text-blue-700 group-hover:text-blue-900">Daily Quest</div>
                <div class="text-sm text-gray-500">Mulai kuis harianmu & dapatkan poin!</div>
            </a>

            {{-- My Point --}}
            <div class="bg-white rounded-xl shadow p-6 text-center border border-green-200">
                <div class="mx-auto w-14 h-14 flex items-center justify-center bg-green-100 rounded-full mb-4">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20H4v-2a3 3 0 015.356-1.857"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4a4 4 0 010 8 4 4 0 010-8z"></path>
                    </svg>
                </div>
                <div class="font-semibold text-lg mb-1 text-green-700">My Point</div>
                <div class="text-3xl font-extrabold text-green-700 mb-2">{{ $myPoint ?? 0 }}</div>
                <div class="text-sm text-gray-500">Total Poinmu Saat Ini</div>
            </div>

        </div>

        {{-- Leaderboard Bar Chart --}}
        <div class="bg-white rounded-xl shadow p-6 mt-10">
            <div class="flex items-center mb-4">
                <svg class="w-6 h-6 text-yellow-600 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"></path>
                </svg>
                <span class="font-semibold text-lg text-yellow-700">Leaderboard</span>
            </div>
            <canvas id="leaderboardChart" height="260"></canvas>
        </div>

        {{-- Leaderboard Table with Badges --}}
        <div class="mt-6">
            <table class="min-w-full border rounded-xl overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 text-left">#</th>
                        <th class="py-2 px-4 text-left">Nama</th>
                        <th class="py-2 px-4 text-left">Poin</th>
                        <th class="py-2 px-4 text-left">Badge</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaderboard as $i => $user)
                        @php
                            $badge = 'Bronze';
                            $badgeColor = 'bg-yellow-400 text-yellow-900';
                            if ($user->score >= 100) {
                                $badge = 'Silver';
                                $badgeColor = 'bg-gray-300 text-gray-800';
                            }
                            if ($user->score >= 200) {
                                $badge = 'Gold';
                                $badgeColor = 'bg-yellow-500 text-yellow-900';
                            }
                            if ($user->score >= 300) {
                                $badge = 'Master';
                                $badgeColor = 'bg-blue-400 text-blue-900';
                            }
                            if ($user->score >= 400) {
                                $badge = 'Champion';
                                $badgeColor = 'bg-red-500 text-white';
                            }
                        @endphp
                        <tr class="{{ $i % 2 ? 'bg-white' : 'bg-gray-50' }}">
                            <td class="py-2 px-4">{{ $i + 1 }}</td>
                            <td class="py-2 px-4">{{ $user->name }}</td>
                            <td class="py-2 px-4">{{ $user->score }}</td>
                            <td class="py-2 px-4">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $badgeColor }}">
                                    {{ $badge }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('leaderboardChart').getContext('2d');
            const labels = @json($leaderboard->pluck('name'));
            const scores = @json($leaderboard->pluck('score'));

            // Determine badge icon per score
            const getBadgeEmoji = (score) => {
                if (score >= 400) return '🏆';      // Champion
                if (score >= 300) return '👑';      // Master
                if (score >= 200) return '🥇';      // Gold
                if (score >= 100) return '🥈';      // Silver
                return '🥉';                        // Bronze
            };
            const badgeEmojis = scores.map(getBadgeEmoji);

            // Chart.js plugin to draw badge icon above each bar
            const badgePlugin = {
                id: 'badgePlugin',
                afterDatasetDraw(chart, args, options) {
                    const { ctx, chartArea: { top }, scales: { x, y } } = chart;
                    chart.getDatasetMeta(0).data.forEach((bar, idx) => {
                        const badge = badgeEmojis[idx];
                        const barCenter = bar.x;
                        const barTop = bar.y - 16;
                        ctx.save();
                        ctx.font = "28px serif";
                        ctx.textAlign = "center";
                        ctx.fillText(badge, barCenter, barTop);
                        ctx.restore();
                    });
                }
            };

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Points',
                        data: scores,
                        backgroundColor: [
                            '#2563eb', '#16a34a', '#eab308', '#ef4444', '#0ea5e9'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true, precision: 0 }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const score = context.parsed.y;
                                    let badge = '🥉';
                                    if (score >= 100) badge = '🥈';
                                    if (score >= 200) badge = '🥇';
                                    if (score >= 300) badge = '👑';
                                    if (score >= 400) badge = '🏆';
                                    return context.dataset.label + ': ' + score + ' ' + badge;
                                }
                            }
                        }
                    }
                },
                plugins: [badgePlugin]
            });
        });
    </script>

@endsection