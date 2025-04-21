<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SolveController extends Controller
{
    public function show(Question $question)
    {
        $userProgress = UserProgress::where('user_id', Auth::id())
            ->where('question_id', $question->id)
            ->first();
            
        $initialCode = $userProgress ? $userProgress->submitted_code : $question->code_template;
        
        return view('solve.show', compact('question', 'initialCode', 'userProgress'));
    }

    public function submit(Request $request, Question $question)
    {
        $validated = $request->validate([
            'code' => 'required',
        ]);

        // Here we would evaluate the code against test cases
        // This is a simplified version - in a real-world app you would use a sandbox
        
        // Save test code to temporary file
        $tempFilePath = storage_path('app/temp/') . uniqid() . '.php';
        if (!file_exists(dirname($tempFilePath))) {
            mkdir(dirname($tempFilePath), 0777, true);
        }
        
        // Write test code with user's submission
        $testCode = "<?php\n" . $validated['code'] . "\n\n";
        $testCode .= "// Test cases\n";
        
        $allTestsPassed = true;
        $results = [];
        
        foreach ($question->test_cases as $testCase) {
            // Add test case execution
            $testCode .= "\n// Test case\n";
            $testCode .= "echo 'Testing: " . addslashes($testCase['input']) . "';\n";
            $testCode .= "echo 'Expected: " . addslashes($testCase['expected']) . "';\n";
            $testCode .= "echo 'Result: ' . " . $testCase['execution'] . ";\n";
        }
        
        file_put_contents($tempFilePath, $testCode);
        
        // Execute the code
        $process = new Process(['php', $tempFilePath]);
        $process->run();
        
        // Remove the temporary file
        unlink($tempFilePath);
        
        if (!$process->isSuccessful()) {
            $output = $process->getErrorOutput();
            $score = 0;
            $allTestsPassed = false;
        } else {
            $output = $process->getOutput();
            // In a real implementation, you would parse the output and calculate score
            $score = $allTestsPassed ? 100 : 0;
        }
        
        // Save progress
        UserProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'question_id' => $question->id,
            ],
            [
                'score' => $score,
                'submitted_code' => $validated['code'],
                'completed_at' => $allTestsPassed ? now() : null,
            ]
        );
        
        return view('solve.result', compact('question', 'output', 'score', 'allTestsPassed'));
    }
}
