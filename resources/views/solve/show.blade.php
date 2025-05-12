<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $question->title }}
        </h2>
    </x-slot>

    <!-- Include SweetAlert2 from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Problem description -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-2xl font-bold shadow">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20l9 2-7-7 7-7-9 2-2-9-2 9-9-2 7 7-7 7 9-2z"/></svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex flex-wrap gap-2 items-center">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold uppercase bg-indigo-100 text-indigo-700">{{ ucfirst($question->category ?? 'Coding') }}</span>
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $question->difficulty === 'easy' ? 'bg-green-100 text-green-800' : ($question->difficulty === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">{{ ucfirst($question->difficulty) }}</span>
                                @php $score = $userProgress->score ?? 0; @endphp
                                @if($userProgress && $userProgress->completed_at)
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Score: {{ $score }}%</span>
                                @endif
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                <div class="bg-indigo-500 h-2 rounded-full transition-all duration-500" style="width: {{ $userProgress && $userProgress->completed_at ? $score : ($userProgress ? 40 : 0) }}%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="prose max-w-none prose-indigo prose-code:bg-gray-100 prose-code:px-1.5 prose-code:rounded prose-pre:bg-gray-900 prose-pre:text-white prose-pre:rounded-lg prose-pre:p-3 prose-h2:text-lg prose-h2:mt-4 prose-h2:mb-2 prose-ul:pl-6 prose-li:marker:text-indigo-400">
                        {!! $descriptionHtml !!}
                    </div>
                </div>

                <!-- Code editor -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <form action="{{ route('solve.submit', $question) }}" method="POST" id="code-form">
                        @csrf
                        <h3 class="text-lg font-medium mb-4">Your Solution</h3>
                        
                        <div class="mb-2 flex items-center gap-2">
                            <label for="language" class="text-sm">Language:</label>
                            <select id="language" name="language" class="border rounded p-1 text-sm">
                                <option value="php" {{ ($userProgress && $userProgress->language === 'php') || (!$userProgress && $question->default_language === 'php') ? 'selected' : '' }}>PHP</option>
                                <option value="python3" {{ ($userProgress && $userProgress->language === 'python3') || (!$userProgress && $question->default_language === 'python3') ? 'selected' : '' }}>Python</option>
                                <option value="javascript" {{ ($userProgress && $userProgress->language === 'javascript') || (!$userProgress && $question->default_language === 'javascript') ? 'selected' : '' }}>JavaScript</option>
                                <option value="java" {{ ($userProgress && $userProgress->language === 'java') || (!$userProgress && $question->default_language === 'java') ? 'selected' : '' }}>Java</option>
                                <option value="c" {{ ($userProgress && $userProgress->language === 'c') || (!$userProgress && $question->default_language === 'c') ? 'selected' : '' }}>C</option>
                                <option value="cpp" {{ ($userProgress && $userProgress->language === 'cpp') || (!$userProgress && $question->default_language === 'cpp') ? 'selected' : '' }}>C++</option>
                                <option value="go" {{ ($userProgress && $userProgress->language === 'go') || (!$userProgress && $question->default_language === 'go') ? 'selected' : '' }}>Go</option>
                                <option value="ruby" {{ ($userProgress && $userProgress->language === 'ruby') || (!$userProgress && $question->default_language === 'ruby') ? 'selected' : '' }}>Ruby</option>
                                <option value="rust" {{ ($userProgress && $userProgress->language === 'rust') || (!$userProgress && $question->default_language === 'rust') ? 'selected' : '' }}>Rust</option>
                                <option value="csharp" {{ ($userProgress && $userProgress->language === 'csharp') || (!$userProgress && $question->default_language === 'csharp') ? 'selected' : '' }}>C#</option>
                                <option value="typescript" {{ ($userProgress && $userProgress->language === 'typescript') || (!$userProgress && $question->default_language === 'typescript') ? 'selected' : '' }}>TypeScript</option>
                            </select>
                            <button type="button" id="template-btn" class="ml-2 bg-blue-100 hover:bg-blue-200 text-blue-700 px-2 py-1 rounded text-xs flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Apply Template
                            </button>
                            <label for="run-stdin" class="ml-4 text-sm">Input (stdin):</label>
                            <input id="run-stdin" type="text" class="border rounded p-1 text-sm w-40" placeholder="Optional input">
                            <button type="button" id="run-btn" class="ml-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                                <i class="fas fa-play mr-1"></i> Run
                            </button>
                        </div>
                        
                        <div class="mb-4">
                            <textarea name="code" id="code-editor" class="w-full h-96 font-mono text-sm p-4 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ $initialCode }}</textarea>
                        </div>
                        
                        <div id="run-output-card" class="hidden mb-4">
                            <div class="rounded-lg shadow-md bg-gray-900 overflow-hidden">
                                <div class="flex border-b border-gray-800">
                                    <div class="px-4 py-2 text-xs font-bold text-green-300">Output</div>
                                    <div class="px-4 py-2 text-xs font-bold text-red-300">Error</div>
                                    <div class="px-4 py-2 text-xs font-bold text-blue-300">Exit Code</div>
                                </div>
                                <div class="grid grid-cols-3 divide-x divide-gray-800">
                                    <pre id="run-output-stdout" class="bg-gray-900 text-green-200 font-mono text-xs p-3 whitespace-pre-wrap break-words">-</pre>
                                    <pre id="run-output-stderr" class="bg-gray-900 text-red-200 font-mono text-xs p-3 whitespace-pre-wrap break-words">-</pre>
                                    <pre id="run-output-exit" class="bg-gray-900 text-blue-200 font-mono text-xs p-3 whitespace-pre-wrap break-words">-</pre>
                                </div>
                            </div>
                        </div>
                        
                        <button type="button" id="ai-btn" class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Minta Saran AI
                        </button>
                        <div id="ai-feedback" class="bg-purple-50 text-purple-900 rounded p-3 text-sm mb-4 hidden"></div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                Run and Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Define templates for each language
        const templates = {
            'cpp': `#include <iostream>
#include <vector>
#include <string>
#include <algorithm>
using namespace std;

int main() {
    // Tulis kode Anda di sini
    cout << "Hello, World!" << endl;
    
    return 0;
}`,
            'c': `#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int main() {
    // Tulis kode Anda di sini
    printf("Hello, World!\\n");
    
    return 0;
}`,
            'java': `public class Main {
    public static void main(String[] args) {
        // Tulis kode Anda di sini
        System.out.println("Hello, World!");
    }
}`,
            'python3': `# Tulis kode Anda di sini
print("Hello, World!")

# Fungsi contoh
def greet(name):
    return f"Hello, {name}!"

# Memanggil fungsi
print(greet("Programmer"))`,
            'javascript': `// Tulis kode Anda di sini
console.log("Hello, World!");

// Fungsi contoh
function greet(name) {
    return \`Hello, \${name}!\`;
}

// Memanggil fungsi
console.log(greet("Programmer"));`,
            'php': `<?php
// Tulis kode Anda di sini
echo "Hello, World!\\n";

// Fungsi contoh
function greet($name) {
    return "Hello, $name!";
}

// Memanggil fungsi
echo greet("Programmer") . "\\n";
?>`,
            'go': `package main

import "fmt"

func main() {
    // Tulis kode Anda di sini
    fmt.Println("Hello, World!")
}`,
            'ruby': `# Tulis kode Anda di sini
puts "Hello, World!"

# Fungsi contoh
def greet(name)
  "Hello, #{name}!"
end

# Memanggil fungsi
puts greet("Programmer")`,
            'rust': `fn main() {
    // Tulis kode Anda di sini
    println!("Hello, World!");
}`,
            'csharp': `using System;

class Program {
    static void Main() {
        // Tulis kode Anda di sini
        Console.WriteLine("Hello, World!");
    }
}`,
            'typescript': `// Tulis kode Anda di sini
console.log("Hello, World!");

// Fungsi contoh dengan tipe data
function greet(name: string): string {
    return \`Hello, \${name}!\`;
}

// Memanggil fungsi
console.log(greet("Programmer"));`
        };

        // Function to load template with SweetAlert
        document.getElementById('template-btn').addEventListener('click', function() {
            const language = document.getElementById('language').value;
            const editor = document.getElementById('code-editor');
            
            // Check if editor already has code
            if (editor.value.trim() !== '') {
                // Use SweetAlert for confirmation
                Swal.fire({
                    title: 'Apply Template?',
                    text: 'Existing code will be replaced with the new template.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Apply!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Apply template
                        applyTemplate(language, editor);
                        
                        // Show success notification
                        Swal.fire({
                            title: 'Template Applied!',
                            text: 'Template code has been applied.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            } else {
                // If editor is empty, apply template directly
                applyTemplate(language, editor);
                
                // Show success notification
                Swal.fire({
                    title: 'Template Applied!',
                    text: 'Template code has been applied.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
        
        // Function to apply template
        function applyTemplate(language, editor) {
            // Try to get the template from the server first
            fetch(`/api/question/{{ $question->id }}/template/${language}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.template) {
                        editor.value = data.template;
                    } else if (templates[language]) {
                        // Fall back to client-side templates
                        editor.value = templates[language];
                    } else {
                        editor.value = "// Write your code here";
                    }
                })
                .catch(error => {
                    // If error, use client-side templates
                    if (templates[language]) {
                        editor.value = templates[language];
                    } else {
                        editor.value = "// Write your code here";
                    }
                });
        }

        // Run Code with SweetAlert for loading
        document.getElementById('run-btn').addEventListener('click', async function() {
            const code = document.getElementById('code-editor').value;
            const language = document.getElementById('language').value;
            const stdin = document.getElementById('run-stdin').value;
            
            // Check if code is empty
            if (!code.trim()) {
                Swal.fire({
                    title: 'Empty Code',
                    text: 'Please write some code first.',
                    icon: 'warning'
                });
                return;
            }
            
            // Show loading
            Swal.fire({
                title: 'Running Code...',
                text: 'Please wait...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Show output panel
            document.getElementById('run-output-card').classList.remove('hidden');
            document.getElementById('run-output-stdout').textContent = 'Running...';
            document.getElementById('run-output-stderr').textContent = '-';
            document.getElementById('run-output-exit').textContent = '-';
            
            try {
                const response = await fetch("{{ route('run.code') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        language,
                        source: code,
                        stdin
                    })
                });
                
                const data = await response.json();
                
                // Close loading
                Swal.close();
                
                // Show results
                document.getElementById('run-output-stdout').textContent = data.stdout || data.output || '-';
                document.getElementById('run-output-stderr').textContent = data.stderr || data.error || '-';
                document.getElementById('run-output-exit').textContent = data.code !== undefined ? data.code : (data.exitCode !== undefined ? data.exitCode : '-');
                
                // Scroll to results
                document.getElementById('run-output-card').scrollIntoView({ behavior: 'smooth' });
            } catch (e) {
                // Close loading and show error
                Swal.close();
                
                document.getElementById('run-output-stdout').textContent = '-';
                document.getElementById('run-output-stderr').textContent = 'Request failed: ' + e.message;
                document.getElementById('run-output-exit').textContent = '-';
                
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to run code: ' + e.message,
                    icon: 'error'
                });
            }
        });

        // AI Suggestion with SweetAlert
document.getElementById('ai-btn').addEventListener('click', async function() {
    const code = document.getElementById('code-editor').value;
    const language = document.getElementById('language').value;
    const aiDiv = document.getElementById('ai-feedback');
    
    // Check if code is empty
    if (!code.trim()) {
        Swal.fire({
            title: 'Kode Kosong',
            text: 'Silakan tulis kode terlebih dahulu untuk mendapatkan saran AI.',
            icon: 'warning'
        });
        return;
    }
    
    // Show loading
    Swal.fire({
        title: 'Meminta Saran AI...',
        text: 'Harap tunggu...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    aiDiv.classList.remove('hidden');
    aiDiv.textContent = 'Meminta saran AI...';
    try {
        const resp = await fetch("{{ route('analyze.code') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                code,
                language,
                question_id: {{ $question->id }}, // Pass the question ID
            })
        });
        
        const data = await resp.json();
        
        // Close loading
        Swal.close();
        
        if (data.feedback) {
            // Format the feedback with Markdown
            const formattedFeedback = data.feedback
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>') // Bold
                .replace(/\*(.*?)\*/g, '<em>$1</em>') // Italic
                .replace(/```([\s\S]*?)```/g, '<pre class="bg-gray-800 text-white p-2 rounded my-2 overflow-x-auto">$1</pre>') // Code blocks
                .replace(/`(.*?)`/g, '<code class="bg-gray-100 px-1 rounded">$1</code>') // Inline code
                .replace(/\n/g, '<br>'); // Line breaks
            
            aiDiv.innerHTML = formattedFeedback;
            
            // Scroll to feedback
            aiDiv.scrollIntoView({ behavior: 'smooth' });
        } else if (data.error) {
            aiDiv.innerHTML = '<span class="text-red-500">Error:</span> ' + data.error;
            
            Swal.fire({
                title: 'Error',
                text: data.error,
                icon: 'error'
            });
        } else {
            aiDiv.innerHTML = '<span class="text-red-500">Error:</span> Respons AI tidak valid';
            
            Swal.fire({
                title: 'Error',
                text: 'Respons AI tidak valid',
                icon: 'error'
            });
        }
    } catch (e) {
        // Close loading and show error
        Swal.close();
        
        aiDiv.innerHTML = '<span class="text-red-500">Error:</span> ' + e.message;
        
        Swal.fire({
            title: 'Error',
            text: 'Gagal mendapatkan saran AI: ' + e.message,
            icon: 'error'
        });
    }
});

        // Form submission with validation
        document.getElementById('code-form').addEventListener('submit', function(e) {
            const codeEditor = document.getElementById('code-editor');
            if (!codeEditor.value.trim()) {
                e.preventDefault();
                Swal.fire({
                    title: 'Empty Code',
                    text: 'Please write some code first before submitting.',
                    icon: 'warning'
                });
            }
        });
        
        // Handle language change with SweetAlert
        document.getElementById('language').addEventListener('change', function() {
            const language = this.value;
            const editor = document.getElementById('code-editor');
            
            // If editor is not empty, ask for confirmation
            if (editor.value.trim() !== '') {
                Swal.fire({
                    title: 'Change Language',
                    text: `Do you want to apply the ${language} template?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Apply Template!',
                    cancelButtonText: 'No, Keep My Code'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Apply template
                        applyTemplate(language, editor);
                        
                        // Show success notification
                        Swal.fire({
                            title: 'Template Applied!',
                            text: `${language} template has been applied.`,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            } else {
                // If editor is empty, apply template directly
                applyTemplate(language, editor);
            }
        });
        
        // Auto-save and load code
        const storageKey = 'code_{{ $question->id }}_';
        
        // Save code when typing
        let saveTimeout;
        document.getElementById('code-editor').addEventListener('input', function() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                const language = document.getElementById('language').value;
                localStorage.setItem(storageKey + language, this.value);
            }, 500);
        });
        
        // Load saved code when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const editor = document.getElementById('code-editor');
            const language = document.getElementById('language').value;
            
            // If there's initial code, use that
            if (editor.value.trim()) {
                return;
            }
            
            // Try to load from localStorage
            const savedCode = localStorage.getItem(storageKey + language);
            if (savedCode) {
                editor.value = savedCode;
            } else {
                // If no saved code, apply template
                applyTemplate(language, editor);
            }
        });
    </script>
</x-app-layout>