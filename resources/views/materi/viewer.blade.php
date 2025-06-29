@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto mt-8 p-6 bg-white rounded-xl shadow-lg space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-blue-700">{{ $materi->title }}</h2>
        <div class="text-gray-500 text-sm" id="timer">Sisa waktu: <span id="time">{{ gmdate("i:s", $remaining) }}</span></div>
    </div>
    <div class="h-[70vh] border rounded-lg overflow-hidden shadow">
        <iframe
            src="{{ asset('storage/' . $materi->file_path) }}"
            class="w-full h-full"
            style="min-height: 500px;"
            frameborder="0"></iframe>
    </div>
</div>
<script>
    // Timer logic: decrease time and store in localStorage/session every second
    let remaining = {{ $remaining }};
    function updateTimer() {
        if (remaining <= 0) {
            alert("Waktu melihat materi hari ini habis!");
            window.location = "{{ route('materi.index') }}";
            return;
        }
        let m = Math.floor(remaining / 60).toString().padStart(2, '0');
        let s = (remaining % 60).toString().padStart(2, '0');
        document.getElementById('time').textContent = m + ":" + s;
        remaining--;

        // Update timer on server every 10 seconds (to track usage)
        if (remaining % 10 === 0) {
            fetch("{{ route('materi.timer', [$materi->id]) }}", {method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}});
        }

        setTimeout(updateTimer, 1000);
    }
    updateTimer();
</script>
@endsection
