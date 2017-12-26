<?php

namespace App\Http\Repositories;

use App\Post;
use Illuminate\Support\Facades\Auth;

class PostRepository {
    /**
     *  Persist a post in the database
     *
     * @param $data
     * @return bool
     */
    public function save($data)
    {
        $nsfw = (int) $data['nsfw'] === 'on';
        $description = $data['description'];
        $slug = str_slug($description).'-'.str_random(10);

        $post = new Post($data);
        $post->slug = $slug;
        $post->nsfw = $nsfw;
        $post->user_id = Auth::id();

        return $post->save();
    }
}
