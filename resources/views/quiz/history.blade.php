@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-blue-100">
    <h1 class="text-2xl font-bold mb-6 text-blue-700 text-center">Riwayat Jawaban Kamu</h1>
    @if($answers->isEmpty())
        <div class="text-center text-gray-500">Belum ada riwayat jawaban.</div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border rounded-xl">
                <thead>
                    <tr class="bg-blue-100 text-blue-700">
                        <th class="py-2 px-3">Waktu</th>
                        <th class="py-2 px-3">Soal</th>
                        <th class="py-2 px-3">Jawaban</th>
                        <th class="py-2 px-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($answers as $item)
                        <tr class="border-t last:border-b hover:bg-blue-50">
                            <td class="py-2 px-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->answered_at)->format('d M Y H:i') }}</td>
                            <td class="py-2 px-3">{{ $item->question->question ?? '-' }}</td>
                            <td class="py-2 px-3">{{ $item->answer->answer ?? '-' }}</td>
                            <td class="py-2 px-3">
                                @if($item->is_correct)
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <div class="mt-8 text-center">
        <a href="{{ route('dashboard') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow">Kembali ke Dashboard</a>
    </div>
</div>
@endsection
