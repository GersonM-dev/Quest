@extends('layouts.app')
@section('content')
    <div class="relative min-h-[70vh] flex flex-col items-center justify-center animate-fade-in-up">

        <div class="w-full max-w-xl bg-white/90 backdrop-blur-md p-8 rounded-2xl shadow-2xl border border-blue-100">

            {{-- Progress Bar --}}
            @php
                $progress = (($quiz['current'] + 1) / $quiz['max']) * 100;
            @endphp
            <div class="mb-5">
                <div class="flex justify-center items-center mb-4">
                    <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full font-bold shadow text-lg">
                        Sisa waktu soal: <span id="question-timer"></span>
                    </span>
                </div>

                <div
                    class="w-full bg-gradient-to-r from-blue-100 via-blue-200 to-blue-100 rounded-full h-5 relative overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-sky-400 h-5 rounded-full shadow-inner transition-all duration-500"
                        style="width: {{ $progress }}%"></div>
                    <div class="absolute inset-0 flex justify-center items-center text-sm font-semibold text-blue-700">
                        {{ round($progress) }}%
                    </div>
                </div>
                <div class="mt-2 text-gray-700 text-sm text-center tracking-wide">Soal <span
                        class="font-semibold text-blue-600">{{ $quiz['current'] + 1 }}</span> dari <span
                        class="font-semibold">{{ $quiz['max'] }}</span></div>
            </div>

            <div class="text-xl font-bold text-blue-800 mb-7 text-center animate-pop">{{ $question->question }}</div>

            <form id="quiz-form">
                @csrf
                <div class="space-y-4">
                    @foreach($question->answers as $ans)
                        <label class="block cursor-pointer group transition">
                            <input type="radio" name="answer_id" value="{{ $ans->id }}" class="peer hidden">
                            <div
                                class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 transition-all duration-200 group-hover:border-blue-400 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 peer-checked:shadow-lg">
                                <span class="text-base font-medium">{{ $ans->answer }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                <button type="submit"
                    class="mt-7 w-full py-3 rounded-xl bg-gradient-to-tr from-blue-500 to-sky-400 text-white font-bold shadow-lg hover:from-blue-600 hover:to-sky-500 transition transform hover:-translate-y-1 text-lg">Kirim
                    Jawaban</button>
            </form>
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
                transform: scale(0.95);
            }

            60% {
                transform: scale(1.03);
            }

            100% {
                transform: scale(1);
            }
        }

        .animate-pop {
            animation: pop 0.6s cubic-bezier(.34, 1.56, .64, 1) both;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let timeLeft = {{ $questionTime }};
        let timerDisplay = document.getElementById('question-timer');

        function startQuestionTimer() {
            function update() {
                if (timeLeft < 0) return; // avoid negative timer if double-called
                let m = Math.floor(timeLeft / 60).toString().padStart(2, '0');
                let s = (timeLeft % 60).toString().padStart(2, '0');
                timerDisplay.textContent = `${m}:${s}`;
                if (timeLeft === 0) {
                    // Auto-submit with no answer (or whatever is selected)
                    autoSubmit();
                } else {
                    timeLeft--;
                    setTimeout(update, 1000);
                }
            }
            update();
        }

        function autoSubmit() {
            let form = document.getElementById('quiz-form');
            let checked = form.querySelector('input[name="answer_id"]:checked');
            if (checked) {
                form.dispatchEvent(new Event('submit')); // normal submit if chosen
            } else {
                // POST with no answer selected (null value)
                fetch("{{ route('quiz.answer') }}", {
                    method: "POST",
                    headers: { 'X-CSRF-TOKEN': form._token.value, 'Accept': 'application/json' },
                    body: new URLSearchParams(new FormData(form))
                })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire({
                            title: 'Waktu Habis!',
                            text: 'Jawaban soal ini kosong atau belum dipilih.',
                            icon: 'warning',
                            confirmButtonColor: '#2563eb'
                        }).then(() => {
                            window.location.href = "{{ route('quiz.question') }}";
                        });
                    });
            }
        }

        document.getElementById('quiz-form').addEventListener('submit', function (e) {
            e.preventDefault();
            let form = this;
            let answer_id = form.answer_id.value;

            if (!answer_id) {
                Swal.fire({
                    title: 'Pilih salah satu jawaban!',
                    icon: 'warning',
                    confirmButtonColor: '#2563eb'
                });
                return;
            }

            fetch("{{ route('quiz.answer') }}", {
                method: "POST",
                headers: { 'X-CSRF-TOKEN': form._token.value, 'Accept': 'application/json' },
                body: new URLSearchParams(new FormData(form))
            })
                .then(res => res.json())
                .then(data => {
                    Swal.fire({
                        title: data.status === 'correct' ? 'Benar!' : 'Salah!',
                        text: data.message,
                        icon: data.status === 'correct' ? 'success' : 'error',
                        confirmButtonColor: '#2563eb'
                    }).then(() => {
                        window.location.href = "{{ route('quiz.question') }}";
                    });
                });
        });

        startQuestionTimer();
    </script>
@endsection