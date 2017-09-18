<?php

namespace App\Repositories;

use App\Comment;

class CommentRepository extends BaseRepository
{
    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}
