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
        $like = Like::firstOrCreate([
            'user_id' => auth()->id(),
            'post_id' => $request->post_id,
        ]);

        return response()->json(['success' => true]);
    }
}
