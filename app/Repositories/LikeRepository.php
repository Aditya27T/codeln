<?php
namespace App\Repositories;

use App\Models\Like;

class LikeRepository
{
    public function findByUserAndPost($userId, $postId)
    {
        return Like::where('user_id', $userId)->where('post_id', $postId)->first();
    }
    public function create(array $data)
    {
        return Like::create($data);
    }
    public function delete(Like $like)
    {
        $like->delete();
    }
    public function countByPost($postId)
    {
        return Like::where('post_id', $postId)->count();
    }
}
