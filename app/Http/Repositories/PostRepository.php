<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Post;
use App\Point;

class PostRepository
{
    /**
     * Persist a post in the database
     *
     * @param array $data
     * @return Post
     */
    public function save(array $data)
    {
        $post = new Post($data);
        $post->save();

        return $post;
    }
}
