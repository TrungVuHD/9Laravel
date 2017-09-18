<?php

namespace App\Repositories;

use App\Post;

class PostRepository extends BaseRepository
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}
