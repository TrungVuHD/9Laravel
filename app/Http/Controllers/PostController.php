<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStore;
use Intervention\Image\ImageManagerStatic as Image;
use grandt\ResizeGif\ResizeGif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Services\PostService;
use App\Http\Repositories\PostRepository;
use App\Comment;
use App\Post;
use App\Point;

class PostController extends Controller
{
    protected $repository;
    protected $service;

    public function __construct(PostRepository $repository, PostService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $posts = $this->retrieveHotAjax(0, 20)['posts'];
        return view('9gag.index', ['posts_category' =>'hot', 'posts' => $posts]);
    }

    public function trendingIndex(Request $request)
    {
        $posts = $this->retrieveTrendingAjax(0, 20)['posts'];
        return view('9gag.index', ['posts_category' =>'trending', 'posts' => $posts]);
    }

    public function freshIndex(Request $request)
    {
        $posts = $this->retrieveFreshAjax(0, 20)['posts'];
        return view('9gag.index', ['posts_category' =>'fresh', 'posts' => $posts]);
    }

    public function show($slug)
    {
        $post = Post::slug($slug)->firstOrFail();
        $next_post = Post::next($post->id)->first();
        $comments = Comment::postComments($post->id)->with('subcomments')->get();
        $sub_comments = Comment::postSubComments($post->id);
        $no_points = $post->noPoints();
        $no_comments = $this->service->noComments($comments, $sub_comments);
        $thumb_up = Auth::check() ? Point::thumbUp($post->id)->first() : null;

        $view_data = compact(
            'post',
            'no_points',
            'thumb_up',
            'comments',
            'sub_comments',
            'no_comments',
            'next_post'
        );

        return view('9gag.show', $view_data);
    }

    public function store(PostStore $request)
    {
        $image = $this->service->saveImage($request);
        $data = $request->all() + [ 'image' => $image ];
        $this->repository->save($data);
    }

    public function search(Request $request)
    {

        $this->validate($request, [
            'keyword' => 'required'
        ]);

        $keyword = strtolower($request->keyword);

        $results = Post::where('title', 'like', $keyword.'%')
            ->take(10)
            ->get();

        return $results;
    }

    public function searchIndex(Request $request)
    {

        $query = $request->query();
        $query = $query['query'];

        $posts = Post::where('title', 'like', "%$query%")->paginate(20);
        $total_results = Post::where('title', 'like', "%$query%")->count();

        return view('9gag.search', compact('posts', 'total_results', 'query'));
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

    protected function retrieveTrendingAjax($offset, $limit)
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

    protected function retrieveHotAjax($offset, $limit)
    {

        $offset = (int) $offset;
        $limit = (int) $limit;
        $data = ['success' => true];

        try {
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
        } catch (\Exception $e) {
            $data['success'] = false;
        }

        return $data;
    }
}
