<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $materials = [
            [
                'title' => 'Introduction to Programming Logic',
                'content' => "# Introduction to Programming Logic

Programming is all about solving problems through logical steps. In this material, we'll cover the basics of programming logic.

## Key Concepts

1. **Variables**: Containers for storing data values
2. **Conditional Statements**: Making decisions in code (if/else)
3. **Loops**: Repeating code multiple times
4. **Functions**: Reusable blocks of code

## Example

```js
// Function to calculate sum
function calculateSum(a, b) {
    return a + b;
}

// Example usage
let result = calculateSum(5, 3); // Result: 8
console.log(result);
```",
                'order' => 1,
            ],
            [
                'title' => 'Understanding Data Types',
                'content' => "# Understanding Data Types

Data types are essential concepts in programming that determine what kind of data can be stored and manipulated.

## Common Data Types

1. **String**: Text values like \"Hello World\"
2. **Integer**: Whole numbers like 42 or -7
3. **Float/Double**: Decimal numbers like 3.14
4. **Boolean**: True or false values
5. **Array**: Collection of values

## Example

```js
// Example usage of different data types
let name = 'John'; // String
let age = 25; // Integer
let height = 1.85; // Float
let isStudent = true; // Boolean
let hobbies = ['reading', 'swimming', 'coding']; // Array

console.log(name, age, height, isStudent, hobbies);
```",
                'order' => 2,
            ],
            [
                'title' => 'Working with Arrays',
                'content' => "# Working with Arrays

Arrays are collections of elements identified by an index or a key.

## Array Operations

1. **Creating Arrays**
2. **Accessing Elements**
3. **Adding/Removing Elements**
4. **Iterating Through Arrays**

## Example

```js
// Creating an array
let fruits = ['apple', 'banana', 'orange'];

// Accessing elements
console.log(fruits[0]); // Outputs: apple

// Adding elements
fruits.push('grapes'); // Adding grapes to the array

// Iterating through an array
fruits.forEach(fruit => {
    console.log(fruit);
});
```",
                'order' => 3,
            ],
        ];

        foreach ($materials as $material) {
            Material::create($material);
        }
    }
}
