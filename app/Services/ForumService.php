<?php
namespace App\Services;

use App\Repositories\PostRepository;
use App\Repositories\ReplyRepository;
use App\Repositories\LikeRepository;
use App\Models\Like;

class ForumService
{
    protected $postRepository;
    protected $replyRepository;
    protected $likeRepository;

    public function __construct(PostRepository $postRepository, ReplyRepository $replyRepository, LikeRepository $likeRepository)
    {
        $this->postRepository = $postRepository;
        $this->replyRepository = $replyRepository;
        $this->likeRepository = $likeRepository;
    }

    public function getAllPosts()
    {
        return $this->postRepository->allWithRelations();
    }

    public function createPost(array $data)
    {
        return $this->postRepository->create($data);
    }

    public function createReply(array $data)
    {
        return $this->replyRepository->create($data);
    }

    public function toggleLike($userId, $postId)
    {
        $like = $this->likeRepository->findByUserAndPost($userId, $postId);
        if ($like) {
            $this->likeRepository->delete($like);
            return false;
        } else {
            $this->likeRepository->create(['user_id' => $userId, 'post_id' => $postId]);
            return true;
        }
    }

    public function getLikeCount($postId)
    {
        return $this->likeRepository->countByPost($postId);
    }
}
