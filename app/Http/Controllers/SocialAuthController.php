<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\SocialAccountService;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect the Facebook request
     *
     * @return mixed
     */
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Redirect the Google request
     *
     * @return mixed
     */
    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Authenticate Facebook users
     *
     * @param SocialAccountService $service
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function facebookCallback(SocialAccountService $service)
    {
        $provider = Socialite::driver('facebook')->user();
        $user = $service->createOrGetUser($provider, 'facebook');
        Auth::login($user);

        return redirect('/');
    }

    /**
     * Authenticate Google users
     *
     * @param SocialAccountService $service
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function googleCallback(SocialAccountService $service)
    {
        $provider = Socialite::driver('google')->user();
        $user = $service->createOrGetUser($provider, 'google');
        Auth::login($user);

        return redirect('/');
    }
}
