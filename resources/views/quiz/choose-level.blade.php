@extends('layouts.app')
@section('content')
    <div class="relative flex flex-col items-center justify-center min-h-[80vh]">
        <!-- Floating Card -->
        <div class="relative w-full max-w-md px-6 py-10 bg-white/90 backdrop-blur-lg rounded-2xl shadow-2xl border border-blue-100 space-y-7
            animate-fade-in-up">
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 flex items-center justify-center">
                <!-- Icon in a gradient circle -->
                <div class="bg-gradient-to-tr from-blue-500 to-sky-400 p-4 rounded-full shadow-lg">
                    <svg class="h-10 w-10 text-white drop-shadow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="12" cy="12" r="10" stroke-width="2" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                    </svg>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-center text-blue-700 mb-2 tracking-tight">Pilih Level Quiz</h1>
            <p class="text-center text-gray-500 text-sm mb-4">Mulai petualangan belajarmu! Pilih jenis test & level yang
                sesuai 👇</p>
            <form action="{{ route('quiz.start') }}" method="POST" class="space-y-6 mt-4">
                @csrf

                {{-- Radio: Pretest / Posttest --}}
                <div>
                    <label class="block font-semibold mb-3 text-gray-700">Jenis Test:</label>
                    <div class="flex items-center justify-center gap-8">
                        <label class="flex flex-col items-center cursor-pointer">
                            <span
                                class="bg-blue-50 border border-blue-200 rounded-full p-3 mb-2 transition hover:bg-blue-100">
                                <img src="{{ asset('images/rewind.png') }}" alt="Pretest Icon"
                                    class="h-6 w-6 object-contain text-blue-600">
                            </span>
                            <input type="radio" name="test_type" value="pretest" required class="accent-blue-600">
                            <span class="mt-1 text-blue-600 font-semibold text-sm">Pretest</span>
                        </label>
                        <label class="flex flex-col items-center cursor-pointer">
                            <span
                                class="bg-purple-50 border border-purple-200 rounded-full p-3 mb-2 transition hover:bg-purple-100">
                                <img src="{{ asset('images/after.png') }}" alt="Posttest Icon"
                                    class="h-6 w-6 object-contain text-purple-600">
                            </span>
                            <input type="radio" name="test_type" value="posttest" required class="accent-purple-600">
                            <span class="mt-1 text-purple-600 font-semibold text-sm">Posttest</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-gray-700" for="level">Level Quiz:</label>
                    <select id="level" name="level" required
                        class="block w-full px-4 py-3 rounded-lg border-2 border-blue-100 bg-blue-50 focus:ring-2 focus:ring-blue-300 focus:outline-none text-blue-700 font-semibold">
                        <option value="">Pilih Level</option>
                        <option value="1">Level 1</option>
                        <option value="2">Level 2</option>
                        <option value="3">Level 3</option>
                        <option value="4">Level 4</option>
                    </select>
                </div>
                <button type="submit"
                    class="w-full py-3 rounded-xl bg-gradient-to-tr from-blue-500 to-sky-400 text-white font-bold shadow-lg hover:from-blue-600 hover:to-sky-500 transition transform hover:-translate-y-1">Mulai
                    Quiz</button>
            </form>
        </div>
        <!-- SweetAlert2 YouTube Modal -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'Tonton Video Ini Sebelum Mulai!',
                    html: `<div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:0.5rem;">
                      <iframe src="https://www.youtube.com/embed/DmGN_m_RlKc?si=eAwXR4NS2V9hbLw3"
                        frameborder="0"
                        allow="autoplay; encrypted-media"
                        allowfullscreen
                        style="position:absolute;top:0;left:0;width:100%;height:100%;">
                      </iframe>
                   </div>`,
                    showConfirmButton: true,
                    confirmButtonText: 'Saya Sudah Menonton',
                    width: 600,
                    padding: '2em',
                    customClass: {
                        popup: 'rounded-xl'
                    }
                });
            });
        </script>
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
    </style>
@endsection
