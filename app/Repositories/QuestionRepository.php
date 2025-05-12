<?php
namespace App\Repositories;

use App\Models\Question;

class QuestionRepository
{
    public function all()
    {
        return Question::all();
    }

    public function searchAndFilter($search = null, $level = null)
    {
        $query = Question::query();
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }
        if ($level) {
            $query->where('difficulty', $level);
        }
        return $query->get();
    }
    public function find($id)
    {
        return Question::findOrFail($id);
    }
    public function create(array $data)
    {
        return Question::create($data);
    }
    public function update(Question $question, array $data)
    {
        $question->update($data);
        return $question;
    }
    public function delete(Question $question)
    {
        $question->delete();
    }
}
