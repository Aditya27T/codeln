<?php
namespace App\Repositories;

use App\Models\Reply;

class ReplyRepository
{
    public function create(array $data)
    {
        return Reply::create($data);
    }
}
