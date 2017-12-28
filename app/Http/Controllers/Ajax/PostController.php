<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Post;

class PostController extends Controller
{
    /**
     * List the hot records for ajax consumption
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function hot()
    {
        $posts = Post::hot()
            ->withCount(['points', 'comments'])
            ->paginate(20);

        return PostResource::collection($posts);
    }

    /**
     * List the trending records for ajax consumption
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function trending()
    {
        $posts = Post::trending()
            ->withCount(['points', 'comments'])
            ->paginate(20);

        return PostResource::collection($posts);
    }

    /**
     * List the fresh records for ajax consumption
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function fresh()
    {
        $posts = Post::new()
            ->withCount(['points', 'comments'])
            ->paginate(20);

        return PostResource::collection($posts);
    }
}
