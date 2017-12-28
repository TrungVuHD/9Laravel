<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentIncrementPoint;
use App\Http\Requests\CommentStore;
use App\Http\Resources\CommentPointResource;
use Illuminate\Support\Facades\Auth;
use App\CommentPoint;
use App\Comment;

class CommentController extends Controller
{
    /**
     * Store a record
     *
     * @param CommentStore $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CommentStore $request)
    {
        $comment = new Comment($request->all());
        $comment->user_id  = Auth::id();
        $comment->save();

        return redirect()
            ->back()
            ->with('status', 'The comment has been posted.');
    }

    /**
     * Increment the point number of a comment
     *
     * @param CommentIncrementPoint $request
     * @return CommentPointResource
     */
    public function incrementPoints(CommentIncrementPoint $request)
    {
        $point = new CommentPoint();
        $point->comment_id = $request->comment_id;
        $point->user_id = Auth::id();
        $point->save();

        return new CommentPointResource($point);
    }

    /**
     * Decrement the point number of a comment
     *
     * @param CommentIncrementPoint $request
     * @return CommentPointResource
     */
    public function decrementPoints(CommentIncrementPoint $request)
    {
        $point = CommentPoint::where('comment_id', $request->comment_id)
            ->where('user_id', Auth::id())
            ->delete();

        return new CommentPointResource($point);
    }
}
