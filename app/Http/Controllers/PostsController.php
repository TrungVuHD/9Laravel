<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class PostsController extends Controller
{
    public function index(Request $request)
    {
    	
    	return view('9gag.index');
    }    

    public function show(Request $request)
    {
    	
    	return view('9gag.show');
    }

    public function trendingIndex(Request $request)
    {

    	return view('9gag.index');
    }

    public function freshIndex(Request $request)
    {

        return view('9gag.index');
    }

    public function myProfileIndex() {
        
        $user = Auth::user();

    	return view('9gag.my-profile', ['user' => $user]);
    }

}
