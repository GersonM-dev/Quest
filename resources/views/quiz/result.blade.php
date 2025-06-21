@extends('layouts.app')
@section('content')
@php
    // Adjust your own tier/score logic!
    $badgeTier = 1;
    $badgeName = 'Rookie';
    if ($score >= 400) { $badgeTier = 5; $badgeName = 'Champion'; }
    elseif ($score >= 300) { $badgeTier = 4; $badgeName = 'Master'; }
    elseif ($score >= 200) { $badgeTier = 3; $badgeName = 'Gold'; }
    elseif ($score >= 100) { $badgeTier = 2; $badgeName = 'Silver'; }
    $badgeImages = [
        1 => asset('badges/tier1.png'),
        2 => asset('badges/tier2.png'),
        3 => asset('badges/tier3.png'),
        4 => asset('badges/tier4.png'),
        5 => asset('badges/tier5.png'),
    ];
@endphp
<div class="relative flex flex-col items-center min-h-[70vh] justify-center animate-fade-in-up">
    <div class="w-full max-w-md bg-white/90 backdrop-blur-md p-10 rounded-2xl shadow-2xl border border-blue-100 text-center">

        <h1 class="text-4xl font-extrabold text-blue-700 mb-3 tracking-tight animate-pop">Quiz Selesai!</h1>
        <div class="text-lg mb-3 text-gray-700">Skor akhir kamu:</div>
        
        <div class="mb-6 flex flex-col items-center gap-2">
            <div class="relative flex items-center justify-center mb-1">
                <img src="{{ $badgeImages[$badgeTier] }}" class="w-24 h-24 rounded-full border-4 border-blue-200 shadow-xl bg-white" alt="Badge">
                <div class="absolute bottom-0 right-0 bg-green-500 text-white rounded-full px-3 py-1 text-xs font-semibold shadow -mb-2 -mr-2">{{ $badgeName }}</div>
            </div>
            <div class="text-5xl font-extrabold text-green-600 animate-pop">{{ $score }}</div>
        </div>
        <div class="flex flex-col sm:flex-row justify-center gap-3 mt-8">
            <a href="{{ route('quiz.choose-level') }}" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-xl font-bold shadow hover:bg-blue-700 transition">Ulangi Quiz</a>
            <a href="{{ route('dashboard') }}" class="inline-block px-8 py-3 bg-gray-600 text-white rounded-xl font-bold shadow hover:bg-gray-700 transition">Kembali ke Dashboard</a>
        </div>
    </div>
</div>

<style>
@keyframes fade-in-up {
    from { opacity: 0; transform: translateY(32px);}
    to   { opacity: 1; transform: translateY(0);}
}
.animate-fade-in-up { animation: fade-in-up 0.7s cubic-bezier(.48,1.68,.38,.98) both; }
@keyframes pop {
    0% { transform: scale(0.9);}
    60% { transform: scale(1.05);}
    100% { transform: scale(1);}
}
.animate-pop { animation: pop 0.7s cubic-bezier(.34,1.56,.64,1) both;}
</style>
@endsection
