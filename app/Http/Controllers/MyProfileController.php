<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Comment;
use App\Post;
use App\Point;

class MyProfileController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}


    public function index() 
    {   
        $user = Auth::user();
    	$points = Point::where('user_id', $user->id)->pluck('post_id');
    	$comments = Comment::where('user_id', $user->id)->pluck('post_id');
    	$post_ids = $points->merge($comments);
    	$posts = Post::whereIn('id', $post_ids)->orWhere('user_id', $user->id)->orderBy('id', 'DESC')->get();

    	return view('9gag.my-profile', ['user' => $user, 'posts' => $posts]);
    }

    public function postsIndex()
    {

    	$user = Auth::user();
    	$posts = Post::where('user_id', $user->id)->orderBy('id', 'DESC')->get();
    	return view('9gag.my-profile', ['user' => $user, 'posts' => $posts]);
    }

    public function upvotesIndex()
    {

    	$user = Auth::user();
    	$points = Point::where('user_id', $user->id)->pluck('post_id');
    	$posts = Post::whereIn('id', $points)->orderBy('id', 'DESC')->get();
    	
    	return view('9gag.my-profile', ['user' => $user, 'posts' => $posts]);
    }

    public function commentsIndex()
    {

    	$user = Auth::user();
    	$comments = Comment::where('user_id', $user->id)->pluck('post_id');
    	$posts = Post::whereIn('id', $comments)->orderBy('id', 'DESC')->get();
    	
    	return view('9gag.my-profile', ['user' => $user, 'posts' => $posts]);
    }
}
