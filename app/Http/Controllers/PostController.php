<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostSearch;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostStore;
use App\Http\Services\PostService;
use App\Http\Repositories\PostRepository;
use App\Comment;
use App\Post;
use App\Point;

class PostController extends Controller
{
    /**
     * The Post repository
     *
     * @var PostRepository
     */
    protected $repository;

    /**
     * The Post service
     *
     * @var PostService
     */
    protected $service;

    /**
     * PostController constructor.
     * @param PostRepository $repository
     * @param PostService $service
     */
    public function __construct(PostRepository $repository, PostService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Show a hot listing of records
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::hot()->paginate(20);
        $category = 'hot';

        return view('9gag.index', compact('category', 'posts'));
    }

    /**
     * Show a trending listing of records
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function trending()
    {
        $posts = Post::trending()->paginate(20);
        $category = 'trending';

        return view('9gag.index', compact('category', 'posts'));
    }

    /**
     * Show a fresh listing of records
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function fresh()
    {
        $posts = Post::new()->paginate(20);
        $category = 'fresh';

        return view('9gag.index', compact('category', 'posts'));
    }

    /**
     * Show a record
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * Store a record
     *
     * @param PostStore $request
     * @return PostResource
     */
    public function store(PostStore $request)
    {
        $image = $this->service->storeImage($request);
        $data = array_merge($request->all(), $image);
        $data['slug'] = str_slug($data['title']).'-'.str_random(10);
        $data['user_id'] = Auth::id();

        $post = $this->repository->save($data);

        return new PostResource($post);
    }

    /**
     * Search the records and return a collection
     *
     * @param PostSearch $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search(PostSearch $request)
    {
        $posts = Post::search($request->keyword)->paginate(20);

        return PostResource::collection($posts);
    }

    /**
     * Search the records and return a view
     *
     * @param PostSearch $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchIndex(PostSearch $request)
    {
        $keyword = $request->keyword;
        $posts = Post::search($keyword)->paginate(20);
        $no_posts = $posts->count();

        return view('9gag.search', compact('posts', 'no_posts', 'keyword'));
    }
}
