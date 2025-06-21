@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto mt-12 mb-16 bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-blue-100">
    <h1 class="text-2xl font-bold text-blue-700 mb-6 text-center">Riwayat Kuis Saya</h1>

    @if($quizzes->isEmpty())
        <div class="text-center text-gray-500">Belum ada riwayat kuis.</div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm border rounded-xl shadow">
                <thead>
                    <tr class="bg-blue-100 text-blue-700">
                        <th class="py-2 px-3 text-center">Tanggal</th>
                        <th class="py-2 px-3 text-center">Level</th>
                        <th class="py-2 px-3 text-center">Skor</th>
                        <th class="py-2 px-3 text-center">Status</th>
                        <th class="py-2 px-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizzes as $quiz)
                        <tr class="border-t hover:bg-blue-50 text-center">
                            <td class="py-2 px-3 whitespace-nowrap">{{ $quiz->created_at->format('d M Y H:i') }}</td>
                            <td class="py-2 px-3">{{ $quiz->level }}</td>
                            <td class="py-2 px-3 font-bold text-green-700">{{ $quiz->total_points }}</td>
                            <td class="py-2 px-3">
                                <span class="inline-block px-3 py-1 rounded-full font-semibold
                                    {{ $quiz->status === 'finished' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($quiz->status) }}
                                </span>
                            </td>
                            <td class="py-2 px-3">
                                <a href="{{ route('quiz.detail', $quiz->id) }}"
                                   class="inline-block px-4 py-1.5 rounded-lg bg-blue-500 text-white hover:bg-blue-700 font-semibold shadow transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-8 text-center">
        <a href="{{ route('dashboard') }}" class="inline-block px-6 py-2 bg-gray-600 text-white rounded-xl hover:bg-gray-700 shadow">Kembali ke Dashboard</a>
    </div>
</div>
@endsection
