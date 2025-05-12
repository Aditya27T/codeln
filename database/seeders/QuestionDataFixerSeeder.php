<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionDataFixerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Fixing question data format...');
        
        $questions = Question::all();
        $this->command->info("Found {$questions->count()} questions to process");
        
        $fixedCount = 0;
        
        foreach ($questions as $question) {
            $modified = false;
            
            // Fix test_cases format if needed
            if (!is_array($question->test_cases)) {
                try {
                    $testCases = json_decode($question->test_cases, true);
                    if (json_last_error() == JSON_ERROR_NONE) {
                        $question->test_cases = $testCases;
                        $modified = true;
                    } else {
                        // If invalid JSON, create a default test case template
                        $question->test_cases = [
                            [
                                'input' => 'Sample Input',
                                'expected' => 'Sample Output',
                                'execution' => 'solve("Sample Input")'
                            ]
                        ];
                        $modified = true;
                    }
                } catch (\Exception $e) {
                    Log::error("Error fixing test_cases for question ID {$question->id}: " . $e->getMessage());
                    $this->command->error("Failed to fix test_cases for question ID {$question->id}: " . $e->getMessage());
                }
            }
            
            // Make sure templates exists with at least PHP 
            if (!is_array($question->templates) || empty($question->templates)) {
                $codeTemplate = '';
                
                // Try to get original code_template if it exists as a DB column
                try {
                    $rawQuestion = DB::table('questions')->where('id', $question->id)->first();
                    if ($rawQuestion && property_exists($rawQuestion, 'code_template')) {
                        $codeTemplate = $rawQuestion->code_template;
                    }
                } catch (\Exception $e) {
                    // Column might not exist anymore, ignore
                }
                
                // Build templates with the PHP template
                $question->templates = [
                    'php' => $codeTemplate ?: "<?php\n// Write your solution here\n\nfunction solve(\$input) {\n    // Your code here\n    return null;\n}\n"
                ];
                $modified = true;
            }
            
            // Save if modified
            if ($modified) {
                $question->save();
                $fixedCount++;
            }
        }
        
        $this->command->info("Fixed data for {$fixedCount} questions");
    }
}