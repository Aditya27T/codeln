<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Services\QuestionService;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return view('questions.index', compact('questions'));
    }

    public function show(Question $question)
    {
        return view('questions.show', compact('question'));
    }

    // Admin methods
    public function create()
    {
        return view('admin.questions.create');
    }

    protected $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function store(StoreQuestionRequest $request)
    {
        $this->questionService->create($request->validated());
        return redirect()->route('admin.questions.index')->with('success', 'Question created successfully');
    }

    public function edit(Question $question)
    {
        return view('admin.questions.edit', compact('question'));
    }

    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $this->questionService->update($question, $request->validated());
        return redirect()->route('admin.questions.index')->with('success', 'Question updated successfully');
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('admin.questions.index')->with('success', 'Question deleted successfully');
    }
}
