@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto mt-10 p-8 bg-white rounded-xl shadow space-y-6">
    <h1 class="text-2xl font-bold text-center">Pilih Level Quiz</h1>
    <form action="{{ route('quiz.start') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Radio: Pretest / Posttest --}}
        <div>
            <label class="block font-semibold mb-2">Jenis Test:</label>
            <div class="flex items-center space-x-6">
                <label class="flex items-center">
                    <input type="radio" name="test_type" value="pretest" required class="accent-blue-600">
                    <span class="ml-2">Pretest</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="test_type" value="posttest" required class="accent-blue-600">
                    <span class="ml-2">Posttest</span>
                </label>
            </div>
        </div>

        <select name="level" required class="block w-full p-2 border rounded">
            <option value="">Pilih Level</option>
            <option value="1">Level 1</option>
            <option value="2">Level 2</option>
            <option value="3">Level 3</option>
            <option value="4">Level 4</option>
        </select>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Mulai Quiz</button>
    </form>
</div>
@endsection
