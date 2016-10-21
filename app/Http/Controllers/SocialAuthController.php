<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\SocialAccountService;
use App\Http\Controllers\Controller;
use Socialite;

class SocialAuthController extends Controller
{
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function facebookCallback(SocialAccountService $service)
    {

       	$provider = Socialite::driver('facebook')->user();
       	$user = $service->createOrGetUser($provider, 'facebook');
       	$logged = Auth::login($user);
       	$is_logged = Auth::check();

       	return redirect('/');
    }

    public function googleCallback(SocialAccountService $service)
    {

       	$provider = Socialite::driver('google')->user();
       	$user = $service->createOrGetUser($provider, 'google');
       	$logged = Auth::login($user);
       	$is_logged = Auth::check();

       	return redirect('/');
    }
}