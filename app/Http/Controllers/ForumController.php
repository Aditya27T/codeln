<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reply;
use App\Models\Like;
use App\Services\ForumService;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    protected $forumService;
    public function __construct(ForumService $forumService)
    {
        $this->forumService = $forumService;
    }
    public function index()
    {
        $posts = $this->forumService->getAllPosts();
        return view('forum.index', compact('posts'));
    }

    public function storePost(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        $this->forumService->createPost([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
        ]);
        return back();
    }

    public function storeReply(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required',
        ]);
        $this->forumService->createReply([
            'user_id' => auth()->id(),
            'post_id' => $request->post_id,
            'content' => $request->content,
        ]);
        return back();
    }

    public function like(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);
        $user = auth()->user();
        $liked = $this->forumService->toggleLike($user->id, $request->post_id);
        $likeCount = $this->forumService->getLikeCount($request->post_id);
        return response()->json([
            'success' => true,
            'liked' => $liked,
            'count' => $likeCount
        ]);
    }

    public function threadJson($id)
    {
        $post = Post::with(['user', 'replies.user', 'likes'])->find($id);
        if (!$post) {
            return response()->json(['success' => false]);
        }
        return response()->json([
            'success' => true,
            'thread' => [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'user_name' => $post->user->name ?? '-',
                'created_at_human' => $post->created_at->diffForHumans(),
                'likes_count' => $post->likes->count(),
                'replies' => $post->replies->map(function($r) {
                    return [
                        'user_name' => $r->user->name ?? '-',
                        'content' => $r->content,
                        'created_at_human' => $r->created_at->diffForHumans(),
                    ];
                }),
            ]
        ]);
    }
}
