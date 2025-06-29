@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto mt-20 p-8 bg-white rounded-xl shadow text-center">
    <h2 class="text-2xl font-bold text-red-600 mb-4">Waktu Habis</h2>
    <p class="mb-6">Maaf, waktu melihat materi <span class="font-bold">{{ $materi->title }}</span> hari ini sudah habis.<br>Silakan coba lagi besok!</p>
    <a href="{{ route('materi.index') }}" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Kembali ke Daftar Materi</a>
</div>
@endsection
