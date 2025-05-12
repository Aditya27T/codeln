<?php
namespace App\Services;

use App\Models\Question;

class QuestionService
{
    public function create(array $data)
    {
        $data['test_cases'] = json_decode($data['test_cases'], true);
        return Question::create($data);
    }

    public function update(Question $question, array $data)
    {
        $data['test_cases'] = json_decode($data['test_cases'], true);
        $question->update($data);
        return $question;
    }
}
