<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\PostStore;
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

    public function index()
    {
        $posts = $this->repository->retrieveHotAjax(0, 20);
        //dd($posts->toArray());
        return view('9gag.index', ['posts_category' =>'hot', 'posts' => $posts]);
    }

    public function trendingIndex()
    {
        $posts = $this->repository->retrieveTrendingAjax(0, 20)['posts'];
        return view('9gag.index', ['posts_category' =>'trending', 'posts' => $posts]);
    }

    public function freshIndex()
    {
        $posts = $this->repository->retrieveFreshAjax(0, 20)['posts'];
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
}
