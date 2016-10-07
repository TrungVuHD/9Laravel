<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PostsController extends Controller
{
    public function index(Request $request)
    {
    	
    	return view('9gag.index', ['request' => $request]);
    }    

    public function show(Request $request)
    {
    	
    	return view('9gag.show', ['request' => $request]);
    }

    public function trendingIndex(Request $request)
    {

    	return view('9gag.index', ['request' => $request]);
    }

    public function freshIndex(Request $request)
    {

    	return view('9gag.index', ['request' => $request]);
    }

}
