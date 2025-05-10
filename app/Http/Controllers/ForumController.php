<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reply;
use App\Models\Like;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'replies.user', 'likes'])->latest()->get();
        return view('forum.index', compact('posts'));
    }

    public function storePost(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        Post::create([
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

        Reply::create([
            'user_id' => auth()->id(),
            'post_id' => $request->post_id,
            'content' => $request->content,
        ]);

        return back();
    }

    public function like(Request $request)
    {
        $user = auth()->user();
        $post = \App\Models\Post::findOrFail($request->post_id);
        $existing = $post->likes()->where('user_id', $user->id)->first();
        $liked = false;
        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }
        $likeCount = $post->likes()->count();
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
