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


    public function retrieveCategoryAjax($category, $start)
    {
        $data = ['success' => true];
        $start = (int)$start;
        $category = (int)$category;

        try {
            $data['posts'] = Post::where('cat_id', $category)
                ->orderBy('id', 'desc')
                ->offset($start)
                ->limit(20)
                ->get();

            foreach ($data['posts'] as &$post) {
                if ($post->points->where('post_id', $post->id)->where('user_id', Auth::user()->id)->count()) {
                    $post->active_thumbs_up = true;
                }

                $post->no_comments = $post->comments->count();
                $post->no_points = $post->points->count();
                $post->auth = Auth::check();
                $post->no_auth = !$post->auth;
                $post->isnt_gif = !$post->is_gif;
            }
        } catch (\Exception $e) {
            $data['success'] = false;
        }

        return $data;
    }

    public function retrieveFreshAjax($offset, $limit)
    {
        $offset = (int) $offset;
        $limit = (int) $limit;
        $data = ['success' => true];

        try {
            $data['posts'] = Post::orderBy('id', 'DESC')
                ->offset($offset)
                ->limit($limit)
                ->get();

            foreach ($data['posts'] as &$post) {
                $post->active_thumbs_up = false;

                if (Auth::check()) {
                    if ($post->points->where('post_id', $post->id)->where('user_id', Auth::user()->id)->count()) {
                        $post->active_thumbs_up = true;
                    }
                }

                $post->no_comments = $post->comments->count();
                $post->no_points = $post->points->count();
                $post->auth = Auth::check();
                $post->no_auth = !$post->auth;
                $post->isnt_gif = !$post->is_gif;
            }
        } catch (Exception $e) {
            $data['success']=false;
        }

        return $data;
    }

    public function retrieveTrendingAjax($offset, $limit)
    {

        $offset = (int) $offset;
        $limit = (int) $limit;
        $data = [ 'success' => true ];

        try {
            // get the first part of posts ids
            $post_ids = Point::orderBy('post_id', 'desc')
                ->groupBy('post_id')
                ->having(DB::raw('count(post_id)'), '>', 300)
                ->having(DB::raw('count(post_id)'), '<', 1000)
                ->offset($offset)
                ->limit($limit)
                ->pluck('post_id');

            // get the posts
            $posts = Post::orderBy('id', 'desc')
                ->whereIn('id', $post_ids)
                ->get();

            $limit -= $posts->count();

            $more_posts = Post::orderBy('id', 'desc')
                ->whereNotIn('id', $post_ids)
                ->offset($offset)
                ->limit($limit)
                ->get();

            $posts = $posts->merge($more_posts);

            foreach ($posts as &$post) {
                $post->active_thumbs_up = false;

                if (Auth::check()) {
                    if ($post->points->where('post_id', $post->id)->where('user_id', Auth::user()->id)->count()) {
                        $post->active_thumbs_up = true;
                    }
                }

                $post->no_comments = $post->comments->count();
                $post->no_points = $post->points->count();
                $post->auth = Auth::check();
                $post->no_auth = !$post->auth;
                $post->isnt_gif = !$post->is_gif;
            }

            $data['posts'] = $posts;
        } catch (\Exception $e) {
            $data['success'] = false;
        }

        return $data;
    }

    public function retrieveHotAjax(int $offset, int $limit)
    {
        // get the first part of posts ids
        $post_ids = Point::orderBy('post_id', 'desc')
            ->groupBy('post_id')
            ->having(DB::raw('count(post_id)'), '>=', 1000)
            ->offset($offset)
            ->limit($limit)
            ->pluck('post_id');

        // get the posts
        $posts = Post::orderBy('id', 'desc')
            ->whereIn('id', $post_ids)
            ->get();

        $limit -= $posts->count();

        $more_posts = Post::orderBy('id', 'desc')
            ->whereNotIn('id', $post_ids)
            ->offset($offset)
            ->limit($limit)
            ->get();

        $posts = $posts->merge($more_posts);

        foreach ($posts as &$post) {
            $post->active_thumbs_up = false;
            if (Auth::check()) {
                if ($post->points->where('post_id', $post->id)->where('user_id', Auth::user()->id)->count()) {
                    $post->active_thumbs_up = true;
                }
            }

            $post->no_comments = $post->comments->count();
            $post->no_points = $post->points->count();
            $post->auth = Auth::check();
            $post->no_auth = !$post->auth;
            $post->isnt_gif = !$post->is_gif;
        }

        $data['posts'] = $posts;

        return $posts;
    }
}
