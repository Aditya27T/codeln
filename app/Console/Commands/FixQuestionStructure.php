<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixQuestionStructure extends Command
{
    protected $signature = 'fix:questions';
    protected $description = 'Fix question structure for multi-language support';

    public function handle()
    {
        $this->info('Starting question structure fix...');
        
        // Step 1: Check if we need to add columns
        if (!Schema::hasColumn('questions', 'default_language')) {
            $this->info('Adding default_language column');
            Schema::table('questions', function ($table) {
                $table->string('default_language')->default('php');
            });
        }
        
        if (!Schema::hasColumn('questions', 'templates')) {
            $this->info('Adding templates column');
            Schema::table('questions', function ($table) {
                $table->json('templates')->nullable();
            });
        }
        
        // Step 2: Update templates from code_template if it exists
        if (Schema::hasColumn('questions', 'code_template')) {
            $this->info('Migrating data from code_template to templates');
            $questions = DB::table('questions')->get();
            
            foreach ($questions as $question) {
                $codeTemplate = $question->code_template ?? '';
                
                // Create templates JSON
                $templates = ['php' => $codeTemplate];
                
                // Update the question
                DB::table('questions')
                    ->where('id', $question->id)
                    ->update([
                        'templates' => json_encode($templates)
                    ]);
            }
            
            // Step 3: Drop the old column
            $this->info('Dropping code_template column');
            Schema::table('questions', function ($table) {
                $table->dropColumn('code_template');
            });
        }
        
        // Step 4: Add language column to user_progress if needed
        if (!Schema::hasColumn('user_progress', 'language')) {
            $this->info('Adding language column to user_progress');
            Schema::table('user_progress', function ($table) {
                $table->string('language')->default('php');
            });
        }
        
        // Step 5: Fix test_cases format
        $this->info('Fixing test_cases format');
        $questions = DB::table('questions')->get();
        
        foreach ($questions as $question) {
            // Skip if null
            if (!$question->test_cases) {
                continue;
            }
            
            // Try to decode to check if it's valid JSON
            $testCases = json_decode($question->test_cases, true);
            if (json_last_error() != JSON_ERROR_NONE) {
                // If it's not valid JSON, set to an empty array
                DB::table('questions')
                    ->where('id', $question->id)
                    ->update([
                        'test_cases' => '[]'
                    ]);
            }
        }
        
        $this->info('Question structure fix completed!');
        return 0;
    }
}