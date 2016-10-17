<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Point;
use App\Post;

class PointsController extends Controller
{
    public function incrementPoints(Request $request)
    {
        
        try {

            $this->validate($request, [
                'postId' => 'required|integer'
            ]);

            if( Post::findOrFail($request->postId) ) 
            {
	            $point = new Point();
	            $point->user_id = Auth::user()->id;
	            $point->post_id = $request->postId;
	            $point->save();
            } 
            else 
            {
                return ['success' => false];
            }
        }
        catch (Exception $e) {

            return ['success' => false];
        }
     
        return ['success' => true];
    }

    public function decrementPoints(Request $request)
    {

        try{

            $point = Point::where('user_id', Auth::user()->id)
            			->where('post_id', $request->postId)
            			->firstOrFail();
            $point->delete();
        }
        catch (Exception $e) {

            return ['success' => false];
        }

        return ['success' => true];
    }
}
