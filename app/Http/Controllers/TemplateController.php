<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Get template for a specific question and language
     */
    public function getTemplate(Question $question, $language)
    {
        $template = $question->getTemplate($language);
        
        return response()->json([
            'success' => true,
            'template' => $template
        ]);
    }
}