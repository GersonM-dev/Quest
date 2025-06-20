@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto mt-16 bg-white p-8 rounded-xl shadow text-center">
    <h1 class="text-3xl font-bold mb-4">Quiz Selesai!</h1>
    <div class="text-lg mb-2">Skor akhir kamu:</div>
    <div class="text-5xl font-extrabold mb-6 text-green-600">{{ $score }}</div>
    <a href="{{ route('quiz.choose-level') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Ulangi Quiz</a>
    <a href="{{ route('dashboard') }}" class="inline-block px-6 py-2 mt-2 bg-gray-600 text-white rounded hover:bg-gray-700 ml-2">Kembali ke Dashboard</a>
</div>
@endsection
