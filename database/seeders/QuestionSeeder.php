<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            [
                'title' => 'Find the Maximum Number',
                'description' => "# Find the Maximum Number

Write a function `findMax` that accepts an array of integers and returns the maximum value in the array.

## Example

Input: `[3, 7, 2, 8, 1]`
Output: `8`

Input: `[-5, -2, -10]`
Output: `-2`",
                'difficulty' => 'easy',
                'code_template' => "function findMax(\$numbers) {\n    // Your code here\n}",
                'test_cases' => [
                    [
                        'input' => '[3, 7, 2, 8, 1]',
                        'expected' => '8',
                        'execution' => 'findMax([3, 7, 2, 8, 1])'
                    ],
                    [
                        'input' => '[-5, -2, -10]',
                        'expected' => '-2',
                        'execution' => 'findMax([-5, -2, -10])'
                    ],
                    [
                        'input' => '[42]',
                        'expected' => '42',
                        'execution' => 'findMax([42])'
                    ],
                ],
                'solution' => "# Solution

```php
function findMax(\$numbers) {
    // Check if array is empty
    if (empty(\$numbers)) {
        return null;
    }
    
    // Initialize max with first element
    \$max = \$numbers[0];
    
    // Iterate through array to find max
    foreach (\$numbers as \$number) {
        if (\$number > \$max) {
            \$max = \$number;
        }
    }
    
    return \$max;
}
```

## Explanation

1. First, we check if the array is empty, and return null if it is
2. We initialize our max variable with the first element of the array
3. We iterate through each element of the array
4. If the current element is greater than our current max, we update max
5. Finally, we return the maximum value

Time Complexity: O(n) - where n is the number of elements in the array
Space Complexity: O(1) - we only use a single variable regardless of input size",
            ],
            [
                'title' => 'Reverse a String',
                'description' => "# Reverse a String

Write a function `reverseString` that accepts a string and returns the string reversed.

## Example

Input: `\"hello\"`
Output: `\"olleh\"`

Input: `\"coding challenge\"`
Output: `\"egnellahc gnidoc\"`",
                'difficulty' => 'easy',
                'code_template' => "function reverseString(\$str) {\n    // Your code here\n}",
                'test_cases' => [
                    [
                        'input' => 'hello',
                        'expected' => 'olleh',
                        'execution' => 'reverseString("hello")'
                    ],
                    [
                        'input' => 'coding challenge',
                        'expected' => 'egnellahc gnidoc',
                        'execution' => 'reverseString("coding challenge")'
                    ],
                    [
                        'input' => 'a',
                        'expected' => 'a',
                        'execution' => 'reverseString("a")'
                    ],
                ],
                'solution' => "# Solution

```php
function reverseString(\$str) {
    return strrev(\$str);
}
```

Alternatively, without using PHP's built-in function:

```php
function reverseString(\$str) {
    \$reversed = '';
    \$length = strlen(\$str);
    
    for (\$i = \$length - 1; \$i >= 0; \$i--) {
        \$reversed .= \$str[\$i];
    }
    
    return \$reversed;
}
```

## Explanation

In the first solution, we use PHP's built-in `strrev()` function which reverses a string.

In the alternative solution:
1. We create an empty string to hold our result
2. We iterate through the original string from the last character to the first
3. We append each character to our result string
4. We return the reversed string

Time Complexity: O(n) - where n is the length of the string
Space Complexity: O(n) - we create a new string of the same length",
            ],
            [
                'title' => 'Fibonacci Sequence',
                'description' => "# Fibonacci Sequence

Write a function `fibonacci` that returns the nth number in the Fibonacci sequence. The Fibonacci sequence is defined as follows:
- The first number is 0
- The second number is 1
- Each subsequent number is the sum of the two preceding numbers

## Example

Input: `5`
Output: `3` (the sequence is 0, 1, 1, 2, 3)

Input: `10`
Output: `34` (the sequence is 0, 1, 1, 2, 3, 5, 8, 13, 21, 34)",
                'difficulty' => 'medium',
                'code_template' => "function fibonacci(\$n) {\n    // Your code here\n}",
                'test_cases' => [
                    [
                        'input' => '1',
                        'expected' => '0',
                        'execution' => 'fibonacci(1)'
                    ],
                    [
                        'input' => '5',
                        'expected' => '3',
                        'execution' => 'fibonacci(5)'
                    ],
                    [
                        'input' => '10',
                        'expected' => '34',
                        'execution' => 'fibonacci(10)'
                    ],
                ],
                'solution' => "# Solution

```php
function fibonacci(\$n) {
    if (\$n <= 0) {
        return null;
    }
    if (\$n == 1) {
        return 0;
    }
    if (\$n == 2) {
        return 1;
    }
    
    \$a = 0;
    \$b = 1;
    \$result = 0;
    
    for (\$i = 3; \$i <= \$n; \$i++) {
        \$result = \$a + \$b;
        \$a = \$b;
        \$b = \$result;
    }
    
    return \$result;
}
```

## Explanation

1. We handle base cases: 
   - If n is less than or equal to 0, return null
   - If n is 1, return 0 (the first number in the sequence)
   - If n is 2, return 1 (the second number in the sequence)
2. For n >= 3, we use a loop to calculate the sequence:
   - Initialize values a = 0 and b = 1 for the first two numbers
   - For each step, calculate the next number as the sum of a and b
   - Update a and b for the next iteration
3. Return the final result

Time Complexity: O(n) - we perform n-2 iterations
Space Complexity: O(1) - we use a constant amount of space",
            ],
        ];

        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}
