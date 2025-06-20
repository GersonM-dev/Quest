@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">
    {{-- Progress Bar --}}
    @php
        $progress = (($quiz['current']+1) / $quiz['max']) * 100;
    @endphp
    <div class="w-full bg-gray-200 rounded-full h-4 mb-4">
        <div class="bg-blue-600 h-4 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
    </div>
    <div class="mb-2 text-gray-700 text-sm">Soal {{ $quiz['current']+1 }} dari {{ $quiz['max'] }}</div>
    <div class="text-xl font-semibold mb-6">{{ $question->question }}</div>

    <form id="quiz-form">
        @csrf
        <div class="space-y-3">
            @foreach($question->answers as $ans)
                <label class="block">
                    <input type="radio" name="answer_id" value="{{ $ans->id }}" class="mr-2">
                    {{ $ans->answer }}
                </label>
            @endforeach
        </div>
        <button type="submit" class="mt-6 w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Kirim Jawaban</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('quiz-form').addEventListener('submit', function(e) {
    e.preventDefault();
    let form = this;
    let answer_id = form.answer_id.value;

    if (!answer_id) {
        Swal.fire('Pilih salah satu jawaban!');
        return;
    }

    fetch("{{ route('quiz.answer') }}", {
        method: "POST",
        headers: {'X-CSRF-TOKEN': form._token.value, 'Accept': 'application/json'},
        body: new URLSearchParams(new FormData(form))
    })
    .then(res => res.json())
    .then(data => {
        Swal.fire({
            title: data.status === 'correct' ? 'Benar!' : 'Salah!',
            text: data.message,
            icon: data.status === 'correct' ? 'success' : 'error',
            showConfirmButton: true
        }).then(() => {
            window.location.href = "{{ route('quiz.question') }}";
        });
    });
});
</script>
@endsection
