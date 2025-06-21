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
            'level' => 'required|in:1,2,3,4',
            'test_type' => 'required|in:pretest,posttest',
        ]);

        // Get 10 random questions for chosen level & type
        $answeredQuestionIds = \App\Models\UserAnswer::where('user_id', auth()->id())->pluck('question_id')->toArray();
        $questionsQuery = \App\Models\Question::with('answers')
            ->where('level', $request->level)
            ->whereNotIn('id', $answeredQuestionIds);

        if ($request->test_type === 'pretest') {
            $questionsQuery->where('is_pretest', true);
        } else {
            $questionsQuery->where('is_posttest', true);
        }

        $questions = $questionsQuery->inRandomOrder()->take(10)->get();

        // --- Create a new Quiz entry (status: in_progress)
        $quiz = \App\Models\Quiz::create([
            'user_id' => auth()->id(),
            'total_points' => 0,
            'level' => $request->level,
            'status' => 'in_progress',
            // add 'test_type' if you want (must add to fillable and migration)
        ]);

        // --- Store session
        Session::put('quiz', [
            'quiz_id' => $quiz->id,
            'level' => $request->level,
            'test_type' => $request->test_type,
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
        $question = \App\Models\Question::with('answers')->findOrFail($questionId);

        return view('quiz.question', compact('question', 'quiz'));
    }


    public function submitAnswer(Request $request)
    {
        $quiz = Session::get('quiz');
        $questionId = $quiz['questions'][$quiz['current']];
        $question = \App\Models\Question::with('answers')->findOrFail($questionId);

        $isCorrect = $question->answers()
            ->where('id', $request->answer_id)
            ->where('is_correct', true)
            ->exists();

        $point = $question->points;

        // Save user's answer
        \App\Models\UserAnswer::create([
            'user_id' => auth()->id(),
            'quiz_id' => $quiz['quiz_id'],
            'question_id' => $question->id,
            'answer_id' => $request->answer_id,
            'is_correct' => $isCorrect,
            'answered_at' => now(),
        ]);

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

        // Update the quiz attempt with total_points and status
        $quizModel = \App\Models\Quiz::find($quiz['quiz_id']);
        if ($quizModel) {
            $quizModel->update([
                'total_points' => $score,
                'status' => 'finished',
            ]);
        }

        // Update or create leaderboard
        \App\Models\Leaderboard::updateOrCreate(
            ['user_id' => $userId],
            ['score' => \DB::raw("GREATEST(score, $score)")] // Keep max score, or use "+=" to accumulate
        );

        Session::forget('quiz');
        return view('quiz.result', compact('score'));
    }
    public function history()
    {
        $user = auth()->user();

        // Load user's answer history with question and answer relation
        $answers = \App\Models\UserAnswer::with(['question', 'answer'])
            ->where('user_id', $user->id)
            ->orderByDesc('answered_at')
            ->get();

        return view('quiz.history', compact('answers'));
    }

    public function myQuizzes()
    {
        $quizzes = \App\Models\Quiz::where('user_id', auth()->id())->orderByDesc('created_at')->get();
        return view('quiz.my-quizzes', compact('quizzes'));
    }


}
