<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Question;

class AnalyzeCodeController extends Controller
{
    public function analyze(Request $request)
    {
        // Validate input
        $request->validate([
            'code' => 'required|string',
            'question_id' => 'required|integer',
            'language' => 'required|string',
        ]);

        // Retrieve question from database to get accurate description and test cases
        $question = Question::findOrFail($request->question_id);

        // Get API Key from .env file
        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            Log::error('Gemini API key not set in .env file');
            return response()->json(['error' => 'Gemini API key not set.'], 500);
        }

        // Log for debugging
        Log::debug('Starting code analysis', [
            'question_id' => $request->question_id,
            'language' => $request->language,
            'code_length' => strlen($request->code),
            'api_key_length' => strlen($apiKey)
        ]);

        // Get test cases for selected language
        $testCases = $question->getTestCases($request->language);
        
        // Format test cases for prompt
        $testCasesText = "";
        foreach ($testCases as $index => $testCase) {
            $testCasesText .= "Test Case #" . ($index + 1) . ":\n";
            $testCasesText .= "Input: " . ($testCase['input'] ?? 'N/A') . "\n";
            $testCasesText .= "Expected: " . ($testCase['expected'] ?? 'N/A') . "\n";
            if (isset($testCase['execution'])) {
                $testCasesText .= "Execution: " . $testCase['execution'] . "\n";
            }
            $testCasesText .= "\n";
        }

        // Prepare prompt for code analysis with language-specific details
        $prompt = "Soal: " . $question->description . "\n\n" .
                  "Kode yang ditulis pengguna (" . $this->getLanguageName($request->language) . "):\n```\n" . $request->code . "\n```\n\n" .
                  "Test cases:\n" . $testCasesText . "\n";
                  
        if ($question->solution) {
            $prompt .= "Contoh solusi (untuk referensi kamu, jangan tunjukkan kode lengkapnya ke pengguna):\n```\n" . $question->solution . "\n```\n\n";
        }
        
        $prompt .= "Tolong analisis kode pengguna di atas dan beri saran perbaikan. Perhatikan bahwa kode tersebut ditulis dalam " . $this->getLanguageName($request->language) . ". ";
        $prompt .= "Jawab dalam bahasa Indonesia, ringkas, dan dalam format yang mudah dipahami. Beri tahu apakah kode akan lulus test case, dan apa yang perlu diperbaiki.";
        $prompt .= "\n\nFokus pada:";
        $prompt .= "\n1. Apakah kode berfungsi untuk semua test case?";
        $prompt .= "\n2. Apakah ada masalah sintaks atau bug?";
        $prompt .= "\n3. Apakah kode menghasilkan output yang tepat sesuai format test case?";
        $prompt .= "\n4. Berikan saran perbaikan konkret yang bisa diterapkan.";

        try {
            // API endpoint URL with API key in the URL params (this is how Gemini API expects it)
            $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $apiKey;
            
            // Prepare payload without authentication header
            $payload = [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt
                            ]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.4,
                    'maxOutputTokens' => 1000,
                ]
            ];

            // Send request to Gemini API
            $response = Http::post($apiUrl, $payload);

            // Log response for debugging
            Log::debug('Gemini API response status: ' . $response->status());

            // Check for successful response with expected structure
            if ($response->successful()) {
                $responseData = $response->json();
                
                Log::debug('Gemini API response structure', [
                    'has_candidates' => isset($responseData['candidates']),
                    'response_keys' => array_keys($responseData),
                ]);
                
                if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                    $feedback = $responseData['candidates'][0]['content']['parts'][0]['text'];
                    return response()->json([
                        'feedback' => $feedback
                    ]);
                } else {
                    Log::error('Unexpected Gemini API response structure', [
                        'response' => $responseData
                    ]);
                    
                    return response()->json([
                        'error' => 'Invalid response format from Gemini API',
                        'details' => json_encode($responseData)
                    ], 500);
                }
            } else {
                // Log error if response is not successful
                Log::error('Gemini API Error', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);
                
                return response()->json([
                    'error' => 'Failed to get suggestions from Gemini API (Status: ' . $response->status() . ')',
                    'details' => $response->body()
                ], 500);
            }
        } catch (\Exception $e) {
            // Handle exception and log error
            Log::error('Exception in Gemini API request: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Server error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get proper language name for the prompt
     */
    private function getLanguageName($language)
    {
        $languageMap = [
            'cpp' => 'C++',
            'c' => 'C',
            'python3' => 'Python',
            'python' => 'Python',
            'javascript' => 'JavaScript',
            'js' => 'JavaScript',
            'java' => 'Java',
            'php' => 'PHP',
            'go' => 'Go',
            'golang' => 'Go',
            'ruby' => 'Ruby',
            'rb' => 'Ruby',
            'rust' => 'Rust',
            'rs' => 'Rust',
            'csharp' => 'C#',
            'c#' => 'C#',
            'cs' => 'C#',
            'typescript' => 'TypeScript',
            'ts' => 'TypeScript'
        ];
        
        return $languageMap[$language] ?? ucfirst($language);
    }
}