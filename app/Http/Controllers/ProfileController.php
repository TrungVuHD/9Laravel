<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Post;
use App\Point;

class ProfileController extends Controller
{
    /**
     * Show the profile page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $points = Point::where('user_id', $user->id)->pluck('post_id');
        $comments = Comment::where('user_id', $user->id)->pluck('post_id');
        $post_ids = $points->merge($comments);
        $posts = Post::whereIn('id', $post_ids)->orWhere('user_id', $user->id)->orderBy('id', 'DESC')->get();

        return view('9gag.my-profile', ['user' => $user, 'posts' => $posts]);
    }

    /**
     * Display a listing of posts
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function posts()
    {
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->orderBy('id', 'DESC')->get();

        return view('9gag.my-profile', ['user' => $user, 'posts' => $posts]);
    }

    /**
     * Display a listing of upvotes
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function upvotes()
    {
        $user = Auth::user();
        $points = Point::where('user_id', $user->id)->pluck('post_id');
        $posts = Post::whereIn('id', $points)->orderBy('id', 'DESC')->get();

        return view('9gag.my-profile', ['user' => $user, 'posts' => $posts]);
    }

    /**
     * Display a listing of comments
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function comments()
    {
        $user = Auth::user();
        $comments = Comment::where('user_id', $user->id)->pluck('post_id');
        $posts = Post::whereIn('id', $comments)->orderBy('id', 'DESC')->get();

        return view('9gag.my-profile', ['user' => $user, 'posts' => $posts]);
    }
}
