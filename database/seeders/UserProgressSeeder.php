<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Question;
use App\Models\UserProgress;
use Illuminate\Support\Facades\Hash;

class UserProgressSeeder extends Seeder
{
    public function run(): void
    {
        // Get all student users
        $students = User::where('role', 'student')->get();
        $questions = Question::all();
        
        foreach ($students as $student) {
            // Each student completes a random number of questions
            $completedQuestions = $questions->random(rand(0, $questions->count()));
            
            foreach ($completedQuestions as $question) {
                // 70% chance of completing the question successfully
                $successful = (rand(1, 100) <= 70);
                
                // Generate a solution (simplified for seeding purposes)
                $solutionCode = '';
                if ($question->title === 'Find the Maximum Number') {
                    $solutionCode = "function findMax(\$numbers) {\n    return max(\$numbers);\n}";
                } elseif ($question->title === 'Reverse a String') {
                    $solutionCode = "function reverseString(\$str) {\n    return strrev(\$str);\n}";
                } elseif ($question->title === 'Fibonacci Sequence') {
                    $solutionCode = "function fibonacci(\$n) {\n    if (\$n <= 0) return null;\n    if (\$n == 1) return 0;\n    if (\$n == 2) return 1;\n    \$a = 0; \$b = 1;\n    for (\$i = 3; \$i <= \$n; \$i++) {\n        \$c = \$a + \$b;\n        \$a = \$b;\n        \$b = \$c;\n    }\n    return \$b;\n}";
                }
                
                UserProgress::create([
                    'user_id' => $student->id,
                    'question_id' => $question->id,
                    'score' => $successful ? 100 : rand(0, 60),
                    'submitted_code' => $solutionCode,
                    'completed_at' => $successful ? now()->subMinutes(rand(1, 10000)) : null,
                ]);
            }
        }
    }
}
