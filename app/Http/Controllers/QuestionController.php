<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'difficulty' => 'required|in:easy,medium,hard',
            'code_template' => 'nullable',
            'test_cases' => 'required|json',
            'solution' => 'required',
        ]);

        $validated['test_cases'] = json_decode($validated['test_cases'], true);
        
        Question::create($validated);

        return redirect()->route('admin.questions.index')->with('success', 'Question created successfully');
    }

    public function edit(Question $question)
    {
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'difficulty' => 'required|in:easy,medium,hard',
            'code_template' => 'nullable',
            'test_cases' => 'required|json',
            'solution' => 'required',
        ]);

        $validated['test_cases'] = json_decode($validated['test_cases'], true);
        
        $question->update($validated);

        return redirect()->route('admin.questions.index')->with('success', 'Question updated successfully');
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('admin.questions.index')->with('success', 'Question deleted successfully');
    }
}
