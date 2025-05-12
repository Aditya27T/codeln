<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Question;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Add the default_language column
        // Schema::table('questions', function (Blueprint $table) {
        //     $table->string('default_language')->default('php');
        // });
        
        // // Step 2: Add a new JSON column instead of trying to convert the existing one
        // Schema::table('questions', function (Blueprint $table) {
        //     $table->json('templates')->nullable();
        // });
        
        // Step 3: Copy existing code_template to templates as a JSON object
        $questions = Question::all();
        foreach ($questions as $question) {
            $templates = ['php' => $question->code_template ?? ''];
            $question->templates = $templates;
            $question->save();
        }
        
        // Step 4: Drop the old code_template column
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('code_template');
        });
        
        // Step 5: Fix test_cases if needed
        $questions = Question::all();
        foreach ($questions as $question) {
            // If test_cases is a string, try to convert it to a proper JSON array
            if (is_string($question->test_cases)) {
                try {
                    // Try to decode and re-encode to ensure valid JSON
                    $testCases = json_decode($question->test_cases, true);
                    if (json_last_error() == JSON_ERROR_NONE) {
                        $question->test_cases = $testCases;
                        $question->save();
                    } else {
                        // If invalid JSON, create a placeholder
                        $question->test_cases = [];
                        $question->save();
                    }
                } catch (\Exception $e) {
                    // Handle any conversion errors
                    DB::table('questions')
                        ->where('id', $question->id)
                        ->update(['test_cases' => '[]']);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Step 1: Add back the code_template column
        Schema::table('questions', function (Blueprint $table) {
            $table->text('code_template')->nullable();
        });
        
        // Step 2: Copy data from templates back to code_template
        $questions = Question::all();
        foreach ($questions as $question) {
            $templates = $question->templates;
            if (is_array($templates) && isset($templates['php'])) {
                DB::table('questions')
                    ->where('id', $question->id)
                    ->update(['code_template' => $templates['php']]);
            }
        }
        
        // Step 3: Drop the new columns
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('templates');
            $table->dropColumn('default_language');
        });
    }
};