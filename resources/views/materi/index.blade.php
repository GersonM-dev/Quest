@extends('layouts.app')
@section('content')
  <div class="bg-white py-6 sm:py-8 lg:py-12">
    <div class="mx-auto max-w-screen-2xl px-4 md:px-8">
    <div class="mb-6 flex items-end justify-between gap-4">
      <h2 class="text-2xl font-bold text-gray-800 lg:text-3xl">Materi Pilihan</h2>
    </div>

    <div class="grid gap-x-4 gap-y-8 sm:grid-cols-2 md:gap-x-6 lg:grid-cols-3 xl:grid-cols-4">

      @forelse($materis as $materi)
      <!-- materi card - start -->
      <div>
      <div
      class="group relative mb-2 block h-64 overflow-hidden rounded-lg bg-blue-50 shadow-lg hover:shadow-2xl transition-all lg:mb-3">
      <img src="https://img.icons8.com/color/96/000000/pdf.png" alt="File Materi"
      class="h-36 w-full object-contain object-center transition duration-200 group-hover:scale-105 p-6" />
      <a href="{{ route('materi.view', $materi->id) }}"
      class="absolute inset-0 flex items-end justify-center bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"
      target="_blank">
      <span
        class="mb-4 inline-flex items-center gap-2 rounded-full bg-blue-600 px-4 py-2 text-white font-bold shadow hover:bg-blue-800 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        View
      </span>
      </a>

      </div>
      <div>
      <div class="mb-1 text-gray-800 font-bold truncate lg:text-lg">{{ $materi->title }}</div>
      <div class="mb-2 text-gray-500 text-sm truncate">{{ $materi->deskripsi }}</div>
      <div class="flex items-center gap-2 text-xs text-gray-400">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
        d="M8 7V3m8 4V3m-9 4h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2zm2 4h4" />
      </svg>
      {{ \Carbon\Carbon::parse($materi->date)->format('d M Y') }}
      </div>
      </div>
      </div>
      <!-- materi card - end -->
    @empty
      <div class="col-span-full text-center text-gray-400">Belum ada materi.</div>
    @endforelse

    </div>
    </div>
  </div>
@endsection