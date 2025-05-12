@foreach ($replies as $reply)
    <div class="ml-6 mt-2 border-l-2 border-indigo-200 pl-4">
        <div class="flex justify-between items-start">
            <div class="flex items-center">
                <div class="w-7 h-7 rounded-full bg-indigo-50 flex items-center justify-center mr-2">
                    <i class="fas fa-user text-indigo-400"></i>
                </div>
                <strong>{{ $reply->user->name }}</strong>
            </div>
            <span class="text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
        </div>
        <div class="mt-1">{{ $reply->content }}</div>
        <!-- Nested Reply Form -->
        <div class="reply-form mt-2" id="reply-form-{{ $reply->id }}" style="display: none;">
            <form method="POST" action="{{ route('forum.reply') }}">
                @csrf
                <input type="hidden" name="post_id" value="{{ $reply->post_id }}">
                <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                <textarea name="content" rows="2" class="w-full border-gray-300 rounded-md mt-1" placeholder="Tulis balasan..." required></textarea>
                <div class="flex justify-end space-x-3 mt-1">
                    <button type="button" class="px-2 py-1 border rounded-lg text-gray-700 hover:bg-gray-100 text-xs" onclick="toggleReplyForm({{ $reply->id }})">Cancel</button>
                    <button type="submit" class="bg-gray-800 text-white px-2 py-1 rounded hover:bg-gray-900 text-xs">Balas</button>
                </div>
            </form>
        </div>
        <button class="text-indigo-600 hover:text-indigo-800 text-xs font-medium mt-1" onclick="toggleReplyForm({{ $reply->id }})">
            <i class="fas fa-reply mr-1"></i> Balas
        </button>
        <!-- Recursive children -->
        @if ($reply->children->count())
            @include('forum.reply_children', ['replies' => $reply->children])
        @endif
    </div>
@endforeach
