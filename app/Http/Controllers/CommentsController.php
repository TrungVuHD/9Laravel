<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\CommentPoint;
use App\Comment;

class CommentsController extends Controller
{
	public function store(Request $request)
	{

		$this->validate($request, [
			'comment' => 'required|max:1000',
			'post_id' => 'required|integer',
			'parent_id' => 'integer'
		]);

		$comment = new Comment();
		$comment->comment = $request->comment;
		$comment->post_id = $request->post_id;
		$comment->user_id = Auth::user()->id;
		$comment->parent_id = isset($request->parent_id) ? $request->parent_id : 0;

		$comment->save();

		return redirect()
			->back()
			->with('status', 'The comment has been posted.');
	}

	public function incrementPoints(Request $request)
	{

		try {

			$this->validate($request, [
				'comment_id' => 'required|integer'
			]);

			$point = new CommentPoint();
			$point->comment_id = $request->comment_id;
			$point->user_id = Auth::user()->id;

			$point->save();

		} catch(Exception $e) {

			return ['success' => false];
		}

		return ['success' => true];
	}

	public function decrementPoints(Request $request)
	{

		try {

			$this->validate($request, [
				'comment_id' => 'required|integer'
			]);

			$point = CommentPoint::where('comment_id', $request->comment_id)
				->where('user_id', Auth::user()->id)
				->first();

			$point->delete();

		} catch(Exception $e) {

			return ['success' => false];
		}

		return ['success' => true];
	}
}
