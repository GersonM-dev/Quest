@extends('layouts.app')

@section('content')
    <div class="relative min-h-[90vh] flex flex-col items-center justify-center animate-fade-in-up">

        <div class="w-full max-w-2xl space-y-10">

            <!-- Welcome -->
            <div class="flex flex-col items-center mb-2">
                <div class="bg-gradient-to-tr from-blue-500 to-sky-400 p-2 rounded-full shadow-lg mb-3 animate-pop">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="h-9 w-9 rounded-full shadow" />
                </div>
                <h1 class="text-3xl font-extrabold text-blue-700 text-center tracking-tight">Hai {{ Auth::user()->name }}
                </h1>
            </div>

            <!-- Action Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-7">
                <!-- Daily Quest -->
                <a href="{{ route('quiz.choose-level') }}"
                    class="group block bg-white/90 backdrop-blur-md rounded-2xl shadow-xl hover:shadow-2xl transition-all p-7 text-center border border-blue-100 hover:-translate-y-1 hover:bg-blue-50/50">
                    <div
                        class="mx-auto w-16 h-16 flex items-center justify-center bg-gradient-to-br from-blue-100 via-blue-50 to-blue-200 rounded-full mb-4 group-hover:bg-blue-200 shadow">
                        <svg class="w-8 h-8 text-blue-600 group-hover:text-blue-800 transition" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"></path>
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg>
                    </div>
                    <div class="font-bold text-xl mb-1 text-blue-700 group-hover:text-blue-900">Daily Quest</div>
                    <div class="text-sm text-gray-500">Mulai kuis harianmu & dapatkan poin!</div>
                </a>
                <!-- My Point -->
                @php
                    // Example thresholds, adjust as needed:
                    $badgeTier = 1;
                    $badgeName = 'Tier 1';
                    if ($myPoint >= 100) {
                        $badgeTier = 2;
                        $badgeName = 'Tier 2';
                    }
                    if ($myPoint >= 200) {
                        $badgeTier = 3;
                        $badgeName = 'Tier 3';
                    }
                    if ($myPoint >= 300) {
                        $badgeTier = 4;
                        $badgeName = 'Tier 4';
                    }
                    if ($myPoint >= 400) {
                        $badgeTier = 5;
                        $badgeName = 'Tier 5';
                    }
                    $badgeImages = [
                        1 => asset('badges/tier1.png'), // Change to your own badge images!
                        2 => asset('badges/tier2.png'),
                        3 => asset('badges/tier3.png'),
                        4 => asset('badges/tier4.png'),
                        5 => asset('badges/tier5.png'),
                    ];
                @endphp
                <div
                    class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl p-7 text-center border border-green-100 hover:bg-green-50/50 transition-all">
                    <div class="mx-auto mb-3 flex justify-center gap-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <img src="{{ $badgeImages[$i] }}" alt="Tier {{ $i }}" class="w-12 h-12 object-contain rounded-full border-2
                            {{ $i == $badgeTier ? 'border-green-500 scale-110 shadow-xl bg-white' : 'opacity-50 border-gray-200' }} 
                            transition">
                        @endfor
                    </div>
                    <div class="font-bold text-xl mb-1 text-green-700">My Point</div>
                    <div class="text-4xl font-extrabold text-green-700 mb-2 tracking-wider">{{ $myPoint ?? 0 }}</div>
                    <div class="text-sm text-gray-500">Badge: <span
                            class="font-semibold text-green-600">{{ $badgeName }}</span></div>
                </div>

            </div>

            <!-- Leaderboard -->
            <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl p-8 mt-8 border border-yellow-100">
                <div class="flex items-center mb-5">
                    <div class="bg-gradient-to-tr from-yellow-300 to-yellow-100 rounded-full p-2 mr-3">
                        <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"></path>
                        </svg>
                    </div>
                    <span class="font-bold text-lg text-yellow-700 tracking-wide">Leaderboard</span>
                </div>
                <canvas id="leaderboardChart" height="180"></canvas>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(32px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.7s cubic-bezier(.48, 1.68, .38, .98) both;
        }

        @keyframes pop {
            0% {
                transform: scale(0.8);
            }

            60% {
                transform: scale(1.06);
            }

            100% {
                transform: scale(1);
            }
        }

        .animate-pop {
            animation: pop 0.8s cubic-bezier(.34, 1.56, .64, 1) both;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('leaderboardChart').getContext('2d');
            const data = {
                labels: @json($leaderboard->pluck('name')),
                datasets: [{
                    label: 'Points',
                    data: @json($leaderboard->pluck('score')),
                    backgroundColor: [
                        '#2563eb', '#16a34a', '#eab308', '#ef4444', '#0ea5e9'
                    ],
                    borderRadius: 12,
                    borderWidth: 1.5
                }]
            };

            new Chart(ctx, {
                type: 'bar', // vertical bar (default)
                data: data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0,
                            ticks: { font: { size: 14, weight: 'bold' } }
                        },
                        x: {
                            ticks: { font: { size: 13, weight: 'bold' } }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            padding: 12,
                            backgroundColor: '#fff',
                            titleColor: '#111',
                            bodyColor: '#333',
                            borderColor: '#eab308',
                            borderWidth: 1,
                            cornerRadius: 8
                        }
                    },
                    layout: { padding: { top: 15 } }
                }
            });
        });
    </script>
@endsection