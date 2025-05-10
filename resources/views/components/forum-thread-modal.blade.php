<div id="forum-thread-modal" class="fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl shadow-lg max-w-2xl w-full relative animate-fade-in">
        <button onclick="closeForumModal()" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-2xl">&times;</button>
        <div id="forum-modal-content" class="p-6 min-h-[200px] flex flex-col gap-2">
            <div class="flex justify-center items-center h-40">
                <span class="text-gray-400">Loading...</span>
            </div>
        </div>
    </div>
</div>
<style>
@keyframes fade-in { from { opacity: 0; transform: scale(.96);} to { opacity: 1; transform: scale(1);} }
.animate-fade-in { animation: fade-in .2s; }
</style>
