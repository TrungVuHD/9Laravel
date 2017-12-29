<?php

namespace App\Http\Controllers;

use App\Http\Resources\PointResource;
use App\Http\Requests\PointIncrement;
use Illuminate\Support\Facades\Auth;
use App\Point;

class PointController extends Controller
{
    /**
     * Increment the number of points for a post
     *
     * @param PointIncrement $request
     * @return PointResource
     */
    public function increment(PointIncrement $request)
    {
        $point = new Point();
        $point->user_id = Auth::id();
        $point->post_id = $request->post_id;
        $point->save();

        return new PointResource($point);
    }

    /**
     * Decrement the number of points for a post
     *
     * @param PointIncrement $request
     * @return PointResource
     */
    public function decrement(PointIncrement $request)
    {
        $point = Point::where('user_id', Auth::id())
            ->where('post_id', $request->postId)
            ->delete();

        return new PointResource($point);
    }
}
