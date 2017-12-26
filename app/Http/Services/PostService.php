<?php

namespace App\Http\Services;

use App\Comment;

class PostService
{
    public function noComments(Comment $comments, Comment $sub_comments)
    {
        return (int) ($comments->count() + $sub_comments->get()->count());
    }
}
