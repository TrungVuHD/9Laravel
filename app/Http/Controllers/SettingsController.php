<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SettingsController extends Controller
{
    public function showAccount(Request $request)
    {

    	return view('settings.account', [ 'request' => $request ]);
    }

    public function showPassword(Request $request)
    {

    	return view('settings.password', [ 'request' => $request ]);
    }

    public function showProfile(Request $request)
    {

    	return view('settings.profile', [ 'request' => $request ]);
    }

    public function showMyProfile()
    {

    	return view('settings.my-profile');
    }
}
