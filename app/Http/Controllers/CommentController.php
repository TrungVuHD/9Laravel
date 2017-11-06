<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\CommentPoint;
use App\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect('login')
                ->with('status', 'You need to be logged-in in order to comment.');
        }

        $this->validate($request, [
            'comment' => 'required|max:1000',
            'post_id' => 'required|integer',
            'parent_id' => 'integer'
        ]);
        // add the processed slug variable to the request array
        $parent_id = (int) $request->parent_id;
        $request->request->add(['parent_id' => $parent_id]);
        $comment = new Comment($request->all());
        $comment->user_id  = Auth::id();
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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
            return ['success' => false];
        }

        return ['success' => true];
    }
}
