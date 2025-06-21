@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto mt-12 mb-16 bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-blue-100">
    <h1 class="text-2xl font-bold text-blue-700 mb-6 text-center">Detail Kuis</h1>

    <div class="mb-6 flex flex-wrap justify-center gap-5 items-center">
        <div>
            <div class="text-gray-500 text-xs">Level</div>
            <div class="text-lg font-bold text-blue-600">{{ $quiz->level }}</div>
        </div>
        <div>
            <div class="text-gray-500 text-xs">Tanggal</div>
            <div class="text-lg font-bold text-blue-600">{{ $quiz->created_at->format('d M Y H:i') }}</div>
        </div>
        <div>
            <div class="text-gray-500 text-xs">Skor</div>
            <div class="text-lg font-extrabold text-green-700">{{ $quiz->total_points }}</div>
        </div>
        <div>
            <div class="text-gray-500 text-xs">Status</div>
            <span class="inline-block px-4 py-1 rounded-full font-semibold
                {{ $quiz->status === 'finished' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                {{ ucfirst($quiz->status) }}
            </span>
        </div>
    </div>

    @if($quiz->userAnswers->isEmpty())
        <div class="text-center text-gray-500">Belum ada data jawaban untuk kuis ini.</div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm border rounded-xl shadow">
                <thead>
                    <tr class="bg-blue-100 text-blue-700">
                        <th class="py-2 px-3">No</th>
                        <th class="py-2 px-3">Soal</th>
                        <th class="py-2 px-3">Jawaban Kamu</th>
                        <th class="py-2 px-3">Status</th>
                        <th class="py-2 px-3">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quiz->userAnswers as $i => $ans)
                        <tr class="border-t hover:bg-blue-50">
                            <td class="py-2 px-3 text-center">{{ $i+1 }}</td>
                            <td class="py-2 px-3">{{ $ans->question->question ?? '-' }}</td>
                            <td class="py-2 px-3">{{ $ans->answer->answer ?? '-' }}</td>
                            <td class="py-2 px-3">
                                @if($ans->is_correct)
                                    <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded-full font-semibold">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Benar
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 rounded-full font-semibold">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Salah
                                    </span>
                                @endif
                            </td>
                            <td class="py-2 px-3">{{ \Carbon\Carbon::parse($ans->answered_at)->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-8 text-center">
        <a href="{{ route('quiz.my-quizzes') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow">Kembali ke Riwayat Kuis</a>
        <a href="{{ route('dashboard') }}" class="inline-block px-6 py-2 bg-gray-600 text-white rounded-xl hover:bg-gray-700 shadow ml-2">Dashboard</a>
    </div>
</div>
@endsection
