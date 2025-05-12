<?php
namespace App\Services;

use App\Models\Question;
use App\Repositories\QuestionRepository;

class QuestionService
{
    protected $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }
    public function create(array $data)
    {
        $data['test_cases'] = json_decode($data['test_cases'], true);
        return $this->questionRepository->create($data);
    }

    public function update(Question $question, array $data)
    {
        $data['test_cases'] = json_decode($data['test_cases'], true);
        return $this->questionRepository->update($question, $data);
    }

    public function all()
    {
        return $this->questionRepository->all();
    }

    public function find($id)
    {
        return $this->questionRepository->find($id);
    }

    public function delete(Question $question)
    {
        return $this->questionRepository->delete($question);
    }
}
