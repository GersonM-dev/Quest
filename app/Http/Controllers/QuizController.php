<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuizController extends Controller
{
    public function chooseLevel()
    {
        return view('quiz.choose-level');
    }

    public function start(Request $request)
    {
        $request->validate([
            'level' => 'required|in:1,2,3,4'
        ]);
        // Get 10 random questions for chosen level
        $answeredQuestionIds = \App\Models\UserAnswer::where('user_id', auth()->id())->pluck('question_id')->toArray();
        $questions = Question::with('answers')
            ->where('level', $request->level)
            ->whereNotIn('id', $answeredQuestionIds)
            ->inRandomOrder()
            ->take(10)
            ->get();

        // Store questions and progress in session
        Session::put('quiz', [
            'level' => $request->level,
            'questions' => $questions->pluck('id')->toArray(),
            'current' => 0,
            'score' => 0,
            'max' => $questions->count(),
        ]);

        return redirect()->route('quiz.question');
    }

    public function showQuestion()
    {
        $quiz = Session::get('quiz');
        if (!$quiz || $quiz['current'] >= $quiz['max']) {
            return redirect()->route('quiz.result');
        }

        $questionId = $quiz['questions'][$quiz['current']];
        $question = Question::with('answers')->findOrFail($questionId);

        return view('quiz.question', compact('question', 'quiz'));
    }

    public function submitAnswer(Request $request)
    {
        $quiz = Session::get('quiz');
        $questionId = $quiz['questions'][$quiz['current']];
        $question = Question::with('answers')->findOrFail($questionId);

        $isCorrect = $question->answers()
            ->where('id', $request->answer_id)
            ->where('is_correct', true)
            ->exists();

        $point = $question->points;

        if ($isCorrect) {
            $quiz['score'] += $point;
            $result = [
                'status' => 'correct',
                'message' => 'Benar! +' . $point . ' poin'
            ];
        } else {
            $deduct = ceil($point * 0.5);
            $quiz['score'] -= $deduct;
            if ($quiz['score'] < 0)
                $quiz['score'] = 0;
            $result = [
                'status' => 'wrong',
                'message' => 'Salah! -' . $deduct . ' poin'
            ];
        }

        $quiz['current']++;
        Session::put('quiz', $quiz);

        // Return json for AJAX
        return response()->json($result);
    }

    public function result()
    {
        $quiz = Session::get('quiz');
        if (!$quiz) {
            return redirect()->route('quiz.choose-level');
        }
        $score = $quiz['score'];
        $userId = auth()->id(); // Make sure the user is logged in

        // Update or create leaderboard
        \App\Models\Leaderboard::updateOrCreate(
            ['user_id' => $userId],
            ['score' => \DB::raw("GREATEST(score, $score)")] // Keep max score, or use "+=" to accumulate
        );

        Session::forget('quiz');
        return view('quiz.result', compact('score'));
    }

}
