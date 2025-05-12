<?php
namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    public function allWithRelations()
    {
        return Post::with(['user', 'replies.user', 'likes'])->latest()->get();
    }
    public function create(array $data)
    {
        return Post::create($data);
    }
    public function find($id)
    {
        return Post::findOrFail($id);
    }
}
