<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required',
            'difficulty' => 'required|in:easy,medium,hard',
            'code_template' => 'nullable',
            'test_cases' => 'required|json',
            'solution' => 'required',
        ];
    }
}
