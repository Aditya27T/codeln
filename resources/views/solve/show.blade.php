<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $question->title }}
        </h2>
    </x-slot>

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
                    <form action="{{ route('solve.submit', $question) }}" method="POST">
                        @csrf
                        <h3 class="text-lg font-medium mb-4">Your Solution</h3>
                        
                        <div class="mb-4">
                            <textarea name="code" id="code-editor" class="w-full h-96 font-mono text-sm p-4 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ $initialCode }}</textarea>
                        </div>
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
                                <!-- tambah sesuai kebutuhan -->
                            </select>
                            <label for="run-stdin" class="ml-4 text-sm">Input (stdin):</label>
                            <input id="run-stdin" type="text" class="border rounded p-1 text-sm w-40" placeholder="Optional input">
                            <button type="button" id="run-btn" class="ml-4 bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Run</button>
                        </div>
                        <div id="run-output-card" class="hidden mb-2">
                            <div class="rounded-lg shadow bg-gray-900 p-0 overflow-hidden">
                                <div class="flex border-b border-gray-800">
                                    <span class="px-4 py-2 text-xs font-bold text-green-300">Output</span>
                                    <span class="px-4 py-2 text-xs font-bold text-red-300">Error</span>
                                    <span class="px-4 py-2 text-xs font-bold text-blue-300">Exit Code</span>
                                </div>
                                <div class="grid grid-cols-3 divide-x divide-gray-800">
                                    <pre id="run-output-stdout" class="bg-gray-900 text-green-200 font-mono text-xs p-3 whitespace-pre-wrap break-words">-</pre>
                                    <pre id="run-output-stderr" class="bg-gray-900 text-red-200 font-mono text-xs p-3 whitespace-pre-wrap break-words">-</pre>
                                    <pre id="run-output-exit" class="bg-gray-900 text-blue-200 font-mono text-xs p-3 whitespace-pre-wrap break-words">-</pre>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="ai-btn" class="bg-purple-600 text-white px-3 py-1 rounded hover:bg-purple-700 mb-2">Minta Saran AI</button>
                        <div id="ai-feedback" class="bg-purple-50 text-purple-900 rounded p-3 text-sm mb-4 hidden"></div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                Run and Submit
                            </button>
                        </div>
                        <script>
                        document.getElementById('run-btn').onclick = async function() {
                            const code = document.getElementById('code-editor').value;
                            const language = document.getElementById('run-language').value;
                            const stdin = document.getElementById('run-stdin').value;
                            document.getElementById('run-output-card').classList.remove('hidden');
                            document.getElementById('run-output-stdout').textContent = 'Running...';
                            document.getElementById('run-output-stderr').textContent = '-';
                            document.getElementById('run-output-exit').textContent = '-';
                            try {
                                const resp = await fetch("{{ route('run.code') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                    },
                                    body: JSON.stringify({ language, source: code, stdin })
                                });
                                const data = await resp.json();
                                // Output
                                document.getElementById('run-output-stdout').textContent = data.output ?? data.stdout ?? '-';
                                document.getElementById('run-output-stderr').textContent = data.stderr ?? data.error ?? '-';
                                document.getElementById('run-output-exit').textContent = (data.code !== undefined ? data.code : (data.exitCode !== undefined ? data.exitCode : '-'));
                            } catch (e) {
                                document.getElementById('run-output-stdout').textContent = '-';
                                document.getElementById('run-output-stderr').textContent = 'Request failed: ' + e;
                                document.getElementById('run-output-exit').textContent = '-';
                            }
                        }
                        // AI Suggestion
                        document.getElementById('ai-btn').onclick = async function() {
                            const code = document.getElementById('code-editor').value;
                            const language = document.getElementById('run-language').value;
                            const aiDiv = document.getElementById('ai-feedback');
                            aiDiv.classList.remove('hidden');
                            aiDiv.textContent = 'Meminta saran AI...';
                            try {
                                const resp = await fetch("{{ route('analyze.code') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                    },
                                    body: JSON.stringify({
                                        code,
                                        language,
                                        question: @json($question->description),
                                        reference: @json($question->reference_answer ?? null)
                                    })
                                });
                                const data = await resp.json();
                                if (data.feedback) {
                                    aiDiv.textContent = data.feedback;
                                } else if (data.error) {
                                    aiDiv.textContent = 'Error: ' + data.error;
                                } else {
                                    aiDiv.textContent = JSON.stringify(data);
                                }
                            } catch (e) {
                                aiDiv.textContent = 'Request failed: ' + e;
                            }
                        }
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>