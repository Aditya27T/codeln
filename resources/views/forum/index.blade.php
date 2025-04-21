<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            {{ __('Code Discussion Forum') }}
        </h2>
        <p class="text-gray-600 mt-2">Ask questions and share knowledge about programming</p>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-white via-gray-50 to-white min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <!-- Search and New Post Button -->
            <div class="bg-white shadow rounded-2xl p-6">
                <div class="flex items-center space-x-4">
                    <div class="relative flex-1">
                        <input type="text" placeholder="Search discussions..." class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <button onclick="document.getElementById('new-post-form').classList.toggle('hidden')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-plus mr-2"></i> New Post
                    </button>
                </div>
            </div>

            <!-- New Post Form -->
            <div id="new-post-form" class="bg-white shadow rounded-2xl p-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Create New Discussion</h2>
                <form method="POST" action="{{ route('forum.post') }}">
                    @csrf
                    <div class="mb-4">
                        <input type="text" name="title" class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="Judul Post" required>
                    </div>
                    <div class="mb-4">
                        <textarea name="content" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="Tulis isi post..." required></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('new-post-form').classList.add('hidden')" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">Cancel</button>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">Post Discussion</button>
                    </div>
                </form>
            </div>

            <!-- Discussion List -->
            @foreach ($posts as $post)
                <div class="bg-white shadow rounded-2xl overflow-hidden group">
                    <div class="p-6 border-b border-gray-200 bg-gradient-to-tr from-indigo-500 to-purple-500 text-white">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-xl font-bold">{{ $post->title }}</h3>
                                <p class="text-sm opacity-90">Oleh {{ $post->user->name }} | {{ $post->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full">#{{ $post->id }}</span>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <p class="text-gray-700">{{ Str::limit($post->content, 300) }}</p>

                        <!-- Like and Reply Buttons -->
                        <div class="flex justify-between items-center text-sm text-gray-500">
                            <div class="flex space-x-4">
                                <form method="POST" action="{{ route('forum.like') }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <button type="submit" class="flex items-center text-gray-600 hover:text-indigo-600">
                                        ❤️ {{ $post->likes->count() }} Likes
                                    </button>
                                </form>
                                <button type="button" class="flex items-center text-gray-600 hover:text-indigo-600" onclick="toggleReplies({{ $post->id }})">
                                    💬 {{ $post->replies->count() }} Balasan
                                </button>
                            </div>
                            <button class="text-indigo-600 hover:text-indigo-800 text-sm font-medium" onclick="toggleReplyForm({{ $post->id }})">
                                <i class="fas fa-reply mr-1"></i> Balas
                            </button>
                        </div>

                        <!-- Reply Form -->
                        <div class="reply-form mt-4" id="reply-form-{{ $post->id }}" style="display: none;">
                            <form method="POST" action="{{ route('forum.reply') }}">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <textarea name="content" rows="2" class="w-full border-gray-300 rounded-md mt-3" placeholder="Tulis balasan..." required></textarea>
                                <div class="flex justify-end space-x-3 mt-2">
                                    <button type="button" class="px-3 py-1 border rounded-lg text-gray-700 hover:bg-gray-100 text-sm" onclick="toggleReplyForm({{ $post->id }})">Cancel</button>
                                    <button type="submit" class="bg-gray-800 text-white px-3 py-1 rounded hover:bg-gray-900 text-sm">Balas</button>
                                </div>
                            </form>
                        </div>

                        <!-- Replies Section -->
                        <div class="replies mt-4 space-y-3 hidden" id="replies-{{ $post->id }}">
                            @foreach ($post->replies as $reply)
                                <div class="border-t pt-3 mt-3 text-sm text-gray-600">
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center mr-2">
                                                <i class="fas fa-user text-indigo-500"></i>
                                            </div>
                                            <strong>{{ $reply->user->name }}</strong>
                                        </div>
                                        <span class="text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="mt-2">{{ $reply->content }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function toggleReplyForm(id) {
            const form = document.getElementById('reply-form-' + id);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        function toggleReplies(id) {
            const section = document.getElementById('replies-' + id);
            section.classList.toggle('hidden');
        }
    </script>
</x-app-layout>