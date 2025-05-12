<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $question->title }}
        </h2>
    </x-slot>

    <!-- Tambahkan SweetAlert2 dari CDN -->
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
                            <label for="run-language" class="text-sm">Language:</label>
                            <select id="run-language" class="border rounded p-1 text-sm">
                                <option value="php" selected>PHP</option>
                                <option value="python3">Python</option>
                                <option value="javascript">JavaScript</option>
                                <option value="java">Java</option>
                                <option value="c">C</option>
                                <option value="cpp">C++</option>
                                <option value="go">Go</option>
                                <option value="ruby">Ruby</option>
                                <option value="rust">Rust</option>
                                <option value="csharp">C#</option>
                                <option value="typescript">TypeScript</option>
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
        // Definisikan template untuk setiap bahasa
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

        // Fungsi untuk memuat template dengan SweetAlert
        document.getElementById('template-btn').addEventListener('click', function() {
            const language = document.getElementById('run-language').value;
            const editor = document.getElementById('code-editor');
            
            // Periksa apakah editor sudah memiliki kode
            if (editor.value.trim() !== '') {
                // Gunakan SweetAlert untuk konfirmasi
                Swal.fire({
                    title: 'Terapkan Template?',
                    text: 'Kode yang ada akan diganti dengan template baru.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Terapkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Terapkan template
                        applyTemplate(language, editor);
                        
                        // Tampilkan notifikasi sukses
                        Swal.fire({
                            title: 'Template Diterapkan!',
                            text: 'Kode template telah diterapkan.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            } else {
                // Jika editor kosong, langsung terapkan template
                applyTemplate(language, editor);
                
                // Tampilkan notifikasi sukses
                Swal.fire({
                    title: 'Template Diterapkan!',
                    text: 'Kode template telah diterapkan.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
        
        // Fungsi untuk menerapkan template
        function applyTemplate(language, editor) {
            if (templates[language]) {
                editor.value = templates[language];
            } else {
                editor.value = "// Tulis kode Anda di sini";
            }
        }

        // Run Code dengan SweetAlert untuk loading
        document.getElementById('run-btn').addEventListener('click', async function() {
            const code = document.getElementById('code-editor').value;
            const language = document.getElementById('run-language').value;
            const stdin = document.getElementById('run-stdin').value;
            
            // Periksa apakah kode kosong
            if (!code.trim()) {
                Swal.fire({
                    title: 'Kode Kosong',
                    text: 'Silakan tulis kode terlebih dahulu.',
                    icon: 'warning'
                });
                return;
            }
            
            // Tampilkan loading
            Swal.fire({
                title: 'Menjalankan Kode...',
                text: 'Harap tunggu...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Tampilkan output panel
            document.getElementById('run-output-card').classList.remove('hidden');
            document.getElementById('run-output-stdout').textContent = 'Menjalankan...';
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
                
                // Tutup loading
                Swal.close();
                
                // Tampilkan hasil
                document.getElementById('run-output-stdout').textContent = data.stdout || data.output || '-';
                document.getElementById('run-output-stderr').textContent = data.stderr || data.error || '-';
                document.getElementById('run-output-exit').textContent = data.code !== undefined ? data.code : (data.exitCode !== undefined ? data.exitCode : '-');
                
                // Scroll ke hasil
                document.getElementById('run-output-card').scrollIntoView({ behavior: 'smooth' });
            } catch (e) {
                // Tutup loading dan tampilkan error
                Swal.close();
                
                document.getElementById('run-output-stdout').textContent = '-';
                document.getElementById('run-output-stderr').textContent = 'Request failed: ' + e.message;
                document.getElementById('run-output-exit').textContent = '-';
                
                Swal.fire({
                    title: 'Error',
                    text: 'Gagal menjalankan kode: ' + e.message,
                    icon: 'error'
                });
            }
        });

        // AI Suggestion dengan SweetAlert
        document.getElementById('ai-btn').addEventListener('click', async function() {
            const code = document.getElementById('code-editor').value;
            const language = document.getElementById('run-language').value;
            const aiDiv = document.getElementById('ai-feedback');
            
            // Periksa apakah kode kosong
            if (!code.trim()) {
                Swal.fire({
                    title: 'Kode Kosong',
                    text: 'Silakan tulis kode terlebih dahulu untuk mendapatkan saran AI.',
                    icon: 'warning'
                });
                return;
            }
            
            // Tampilkan loading
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
                        question: @json($question->description),
                        reference: @json($question->solution ?? null)
                    })
                });
                
                const data = await resp.json();
                
                // Tutup loading
                Swal.close();
                
                if (data.feedback) {
                    aiDiv.textContent = data.feedback;
                    // Scroll ke feedback
                    aiDiv.scrollIntoView({ behavior: 'smooth' });
                } else if (data.error) {
                    aiDiv.textContent = 'Error: ' + data.error;
                    Swal.fire({
                        title: 'Error',
                        text: data.error,
                        icon: 'error'
                    });
                } else {
                    aiDiv.textContent = JSON.stringify(data);
                    Swal.fire({
                        title: 'Error',
                        text: 'Respons AI tidak valid',
                        icon: 'error'
                    });
                }
            } catch (e) {
                // Tutup loading dan tampilkan error
                Swal.close();
                
                aiDiv.textContent = 'Request failed: ' + e.message;
                
                Swal.fire({
                    title: 'Error',
                    text: 'Gagal mendapatkan saran AI: ' + e.message,
                    icon: 'error'
                });
            }
        });

        // Form submission dengan validasi
        document.getElementById('code-form').addEventListener('submit', function(e) {
            const codeEditor = document.getElementById('code-editor');
            if (!codeEditor.value.trim()) {
                e.preventDefault();
                Swal.fire({
                    title: 'Kode Kosong',
                    text: 'Silakan tulis kode terlebih dahulu sebelum mengirimkan.',
                    icon: 'warning'
                });
            }
        });
        
        // Handle language change dengan SweetAlert
        document.getElementById('run-language').addEventListener('change', function() {
            const language = this.value;
            const editor = document.getElementById('code-editor');
            
            // Jika editor tidak kosong, tanyakan konfirmasi
            if (editor.value.trim() !== '') {
                Swal.fire({
                    title: 'Ganti Bahasa',
                    text: `Apakah Anda ingin menerapkan template untuk bahasa ${language}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Terapkan Template!',
                    cancelButtonText: 'Tidak, Biarkan Kode Saya'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Terapkan template
                        applyTemplate(language, editor);
                        
                        // Tampilkan notifikasi sukses
                        Swal.fire({
                            title: 'Template Diterapkan!',
                            text: `Template bahasa ${language} telah diterapkan.`,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            } else {
                // Jika editor kosong, langsung terapkan template
                applyTemplate(language, editor);
            }
        });
        
        // Auto-save dan load kode
        const storageKey = 'code_{{ $question->id }}_';
        
        // Simpan kode saat mengetik
        let saveTimeout;
        document.getElementById('code-editor').addEventListener('input', function() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                const language = document.getElementById('run-language').value;
                localStorage.setItem(storageKey + language, this.value);
            }, 500);
        });
        
        // Muat kode tersimpan saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const editor = document.getElementById('code-editor');
            const language = document.getElementById('run-language').value;
            
            // Jika ada kode awal, gunakan itu
            if (editor.value.trim()) {
                return;
            }
            
            // Coba muat dari localStorage
            const savedCode = localStorage.getItem(storageKey + language);
            if (savedCode) {
                editor.value = savedCode;
            } else {
                // Jika tidak ada kode tersimpan, terapkan template
                applyTemplate(language, editor);
            }
        });
    </script>
</x-app-layout>