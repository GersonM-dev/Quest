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
    </div>
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
            borderWidth: 1
        }]
    };

    new Chart(ctx, {
        type: 'bar', // vertical bar (default)
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>
@endsection