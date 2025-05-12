<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'difficulty',
        'templates',
        'test_cases',
        'solution',
        'default_language',
    ];

    protected $casts = [
        'test_cases' => 'array',
        'templates' => 'array',
    ];

    /**
     * Get template for specific language
     * 
     * @param string $language
     * @return string
     */
    public function getTemplate(string $language = null): string
    {
        if (!$language) {
            $language = $this->default_language;
        }
        
        if (isset($this->templates[$language])) {
            return $this->templates[$language];
        }
        
        // Return a default template if no language-specific template exists
        return $this->getDefaultTemplate($language);
    }
    
    /**
     * Get test cases for specific language
     * 
     * @param string $language
     * @return array
     */
    public function getTestCases(string $language = null): array
    {
        if (!$language) {
            $language = $this->default_language;
        }
        
        // If we have language-specific test cases, use those
        if (isset($this->test_cases[$language])) {
            return $this->test_cases[$language];
        }
        
        // Otherwise, use the default test cases (for backward compatibility)
        if (isset($this->test_cases['input']) || isset($this->test_cases[0]['input'])) {
            return $this->test_cases;
        }
        
        return [];
    }
    
    /**
     * Generate a default template for the given language
     */
    protected function getDefaultTemplate(string $language): string
    {
        $templates = [
            'php' => "<?php\n// Write your solution here\n\nfunction solve(\$input) {\n    // Your code here\n    return null;\n}\n",
            'python3' => "# Write your solution here\n\ndef solve(input):\n    # Your code here\n    return None\n",
            'javascript' => "// Write your solution here\n\nfunction solve(input) {\n    // Your code here\n    return null;\n}\n",
            'java' => "public class Solution {\n    public static void main(String[] args) {\n        // Test your solution here\n        System.out.println(solve(\"test\"));\n    }\n    \n    public static String solve(String input) {\n        // Your code here\n        return null;\n    }\n}\n",
            'cpp' => "#include <iostream>\n#include <string>\n\nstd::string solve(std::string input) {\n    // Your code here\n    return \"\";\n}\n\nint main() {\n    // Test your solution here\n    std::cout << solve(\"test\") << std::endl;\n    return 0;\n}\n",
            'c' => "#include <stdio.h>\n#include <stdlib.h>\n#include <string.h>\n\nchar* solve(const char* input) {\n    // Your code here\n    return \"\";\n}\n\nint main() {\n    // Test your solution here\n    printf(\"%s\\n\", solve(\"test\"));\n    return 0;\n}\n",
            'go' => "package main\n\nimport \"fmt\"\n\nfunc solve(input string) string {\n    // Your code here\n    return \"\"\n}\n\nfunc main() {\n    // Test your solution here\n    fmt.Println(solve(\"test\"))\n}\n",
            'ruby' => "# Write your solution here\n\ndef solve(input)\n    # Your code here\n    return nil\nend\n\n# Test your solution here\nputs solve(\"test\")\n",
            'rust' => "fn solve(input: &str) -> String {\n    // Your code here\n    return String::new();\n}\n\nfn main() {\n    // Test your solution here\n    println!(\"{}\", solve(\"test\"));\n}\n",
            'csharp' => "using System;\n\npublic class Solution {\n    public static string Solve(string input) {\n        // Your code here\n        return \"\";\n    }\n    \n    public static void Main() {\n        // Test your solution here\n        Console.WriteLine(Solve(\"test\"));\n    }\n}\n",
            'typescript' => "// Write your solution here\n\nfunction solve(input: string): string {\n    // Your code here\n    return \"\";\n}\n\n// Test your solution here\nconsole.log(solve(\"test\"));\n"
        ];
        
        return $templates[$language] ?? "// Template for $language not found";
    }

    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }
}