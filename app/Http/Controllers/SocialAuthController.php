<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\SocialAccountService;
use Laravel\Socialite\Facades\Socialite;
use App\SocialAccount;

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

    /**
     * Disconnect the Facebook account
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disconnectFacebook()
    {
        SocialAccount::where('user_id', Auth::id())
            ->where('provider', 'facebook')
            ->delete();

        return back()->with('status', 'Facebook is disconnected');
    }

    /**
     * Disconnect the Google account
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disconnectGoogle()
    {
        SocialAccount::where('user_id', Auth::id())
            ->where('provider', 'google')
            ->delete();

        return back()->with('status', 'Google is disconnected');
    }
}
