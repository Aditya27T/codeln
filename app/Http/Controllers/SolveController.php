<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SolveController extends Controller
{
    public function show(Question $question)
    {
        $userProgress = UserProgress::where('user_id', Auth::id())
            ->where('question_id', $question->id)
            ->first();
            
        // Get the code template or previously submitted code
        $language = $userProgress ? $userProgress->language : $question->default_language;
        $initialCode = $userProgress ? $userProgress->submitted_code : $question->getTemplate($language);
        
        // Render markdown description to HTML
        $converter = new \League\CommonMark\GithubFlavoredMarkdownConverter();
        $descriptionHtml = $converter->convert($question->description);
        
        return view('solve.show', compact('question', 'initialCode', 'userProgress', 'descriptionHtml', 'language'));
    }

    public function submit(Request $request, Question $question)
    {
        $validated = $request->validate([
            'code' => 'required',
            'language' => 'required|string',
        ]);

        $code = $validated['code'];
        $language = $validated['language'];
        
        // Get appropriate test cases for this language
        $testCases = $question->getTestCases($language);
        
        // For logging purposes
        Log::info('Evaluating submission', [
            'question_id' => $question->id,
            'user_id' => Auth::id(),
            'language' => $language
        ]);
        
        $allTestsPassed = true;
        $results = [];
        $totalTests = count($testCases);
        $passedTests = 0;
        
        // Prepare for API test execution
        foreach ($testCases as $index => $testCase) {
            // Get test case details
            $input = $testCase['input'] ?? '';
            $expected = $testCase['expected'] ?? '';
            $executionCmd = $testCase['execution'] ?? '';
            
            // Execute the test case using Piston API
            $testResult = $this->executeTestCase($code, $language, $input, $executionCmd);
            
            // Compare results
            $passed = trim($testResult['output']) == trim($expected);
            if (!$passed) {
                $allTestsPassed = false;
            } else {
                $passedTests++;
            }
            
            // Store results for display
            $results[] = [
                'test_case' => $testCase,
                'output' => $testResult['output'],
                'error' => $testResult['error'],
                'passed' => $passed
            ];
            
            // Log for debugging
            Log::debug('Test case execution', [
                'test_index' => $index,
                'language' => $language,
                'passed' => $passed,
                'expected' => $expected,
                'actual' => trim($testResult['output'])
            ]);
        }
        
        // Calculate score based on passed tests
        $score = $totalTests > 0 ? (int) (($passedTests / $totalTests) * 100) : 0;
        
        // Save progress
        UserProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'question_id' => $question->id,
            ],
            [
                'score' => $score,
                'submitted_code' => $validated['code'],
                'language' => $language,
                'completed_at' => $allTestsPassed ? now() : null,
            ]
        );
        
        // Combine all test outputs for display
        $output = $this->formatOutputForDisplay($results);
        
        return view('solve.result', compact('question', 'output', 'score', 'allTestsPassed', 'results', 'passedTests', 'totalTests'));
    }
    
    /**
     * Execute a single test case using the Piston API
     */
    protected function executeTestCase($code, $language, $input, $executionCmd = '')
    {
        // Map the language to Piston format
        $pistonLang = $this->mapLanguage($language);
        $version = $this->getLanguageVersion($pistonLang);
        $fileExt = $this->getFileExtension($pistonLang);
        
        // Prepare the payload
        $payload = [
            'language' => $pistonLang,
            'version' => $version,
            'files' => [
                [
                    'name' => 'main.' . $fileExt,
                    'content' => $code
                ]
            ],
            'stdin' => $input,
            'args' => $executionCmd ? explode(' ', $executionCmd) : [],
            'compile_timeout' => 10000,
            'run_timeout' => 3000,
            'compile_memory_limit' => -1,
            'run_memory_limit' => -1
        ];
        
        try {
            // Send request to Piston API
            $response = Http::timeout(20)
                ->post('https://emkc.org/api/v2/piston/execute', $payload);
            
            if ($response->successful()) {
                $result = $response->json();
                
                // Return formatted results
                return [
                    'output' => $result['run']['stdout'] ?? '',
                    'error' => $result['run']['stderr'] ?? '',
                    'exitCode' => $result['run']['code'] ?? null,
                    'success' => true
                ];
            } else {
                Log::error('Piston API error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                return [
                    'output' => '',
                    'error' => 'API Error: ' . $response->status() . ' - ' . $response->body(),
                    'exitCode' => -1,
                    'success' => false
                ];
            }
        } catch (\Exception $e) {
            Log::error('Exception during test execution', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'output' => '',
                'error' => 'Exception: ' . $e->getMessage(),
                'exitCode' => -1,
                'success' => false
            ];
        }
    }
    
    /**
     * Format test results for display
     */
    protected function formatOutputForDisplay($results)
    {
        $output = "";
        foreach ($results as $index => $result) {
            $output .= "Test Case #" . ($index + 1) . ":\n";
            $output .= "Input: " . ($result['test_case']['input'] ?? 'N/A') . "\n";
            $output .= "Expected: " . ($result['test_case']['expected'] ?? 'N/A') . "\n";
            $output .= "Output: " . $result['output'] . "\n";
            if ($result['error']) {
                $output .= "Error: " . $result['error'] . "\n";
            }
            $output .= "Result: " . ($result['passed'] ? "PASSED" : "FAILED") . "\n";
            $output .= "----------------------------\n";
        }
        return $output;
    }
    
    /**
     * Map language name to Piston format
     */
    protected function mapLanguage($language)
    {
        $languageMap = [
            'cpp' => 'c++',
            'c' => 'c',
            'python3' => 'python',
            'python' => 'python',
            'javascript' => 'javascript',
            'js' => 'javascript',
            'java' => 'java',
            'php' => 'php',
            'go' => 'go',
            'golang' => 'go',
            'ruby' => 'ruby',
            'rb' => 'ruby',
            'rust' => 'rust',
            'rs' => 'rust',
            'csharp' => 'csharp',
            'c#' => 'csharp',
            'cs' => 'csharp',
            'typescript' => 'typescript',
            'ts' => 'typescript'
        ];
        
        return $languageMap[$language] ?? $language;
    }
    
    /**
     * Get file extension for a language
     */
    protected function getFileExtension($language)
    {
        $extensions = [
            'c++' => 'cpp',
            'c' => 'c',
            'python' => 'py',
            'javascript' => 'js',
            'java' => 'java',
            'php' => 'php',
            'go' => 'go',
            'ruby' => 'rb',
            'rust' => 'rs',
            'csharp' => 'cs',
            'typescript' => 'ts'
        ];
        
        return $extensions[$language] ?? $language;
    }
    
    /**
     * Get language version for Piston API
     */
    protected function getLanguageVersion($language)
    {
        // Versions supported by Piston API (from runtime list)
        $versions = [
            'c++' => '10.2.0',
            'c' => '10.2.0',
            'python' => '3.10.0',
            'javascript' => '18.15.0', // Node.js runtime
            'java' => '15.0.2',
            'php' => '8.2.3',
            'go' => '1.16.2',
            'ruby' => '3.0.1',
            'rust' => '1.68.2',
            'csharp' => '6.12.0', // Mono runtime
            'typescript' => '5.0.3'
        ];
        
        return $versions[$language] ?? '0';
    }
}