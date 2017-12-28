<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAccountSettings;
use App\Http\Requests\StorePasswordSettings;
use App\Http\Requests\StoreProfileSettings;
use App\Http\Requests\DestroyAccount;
use App\Http\Services\ImageService;
use App\User;

class SettingController extends Controller
{
    /**
     * @var array All available countries
     */
    protected $countries;

    /**
     * The current logged in user
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected $user;

    public function __construct()
    {
        $this->countries = $this->getCountries();
        $this->user = Auth::user();
    }

    /**
     * Retrieve the countries
     *
     * @return array
     */
    public function geCountries()
    {
        $location = storage_path('app/countries.txt');
        $countries = file_get_contents($location);
        return (array) explode(', ', $countries);
    }

    /**
     * Show the account settings
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAccount()
    {
        return view('settings.account', ['user' => $this->user]);
    }

    /**
     * Show the password settings
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPassword()
    {
        return view('settings.password');
    }

    /**
     * Show the profile page for the current logged in user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProfile()
    {
        return view('settings.profile', [
            'countries' => $this->countries,
            'user' => $this->user
        ]);
    }

    public function showMyProfile()
    {
        return view('settings.my-profile');
    }

    /**
     * Store the account settings
     *
     * @param StoreAccountSettings $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAccount(StoreAccountSettings $request)
    {
        $user = User::findOrFail(Auth::id());
        $user->fill($request->all());
        $user->username = str_slug($request->username);
        $user->save();

        return back()->with('status', 'Account settings were saved');
    }

    /**
     * Store the password settings
     *
     * @param StorePasswordSettings $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function storePassword(StorePasswordSettings $request)
    {
        $user = Auth::user();
        // check to see if the passwords match...
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return back()->with('status', 'The password has been changed');
        }

        return back()->withErrors("The old password is incorrect");
    }

    /**
     * Store the profile settings
     *
     * @param StoreProfileSettings $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeProfile(StoreProfileSettings $request)
    {
        $user = Auth::user();
        $user->fill($request->all());

        // store the avatar
        if ($request->hasFile('avatar_image')) {
            $image_dir = storage_path('app' . DS . 'public' . DS . 'avatars');
            $image_data = ImageService::storeImageFile($request->file('avatar_image'), $image_dir);
            ImageService::multipleSizes($image_data['location'], ImageService::SIZES);

            $user->avatar_image = $image_data['basename'];
        }

        $user->save();

        return back()->with('status', 'Profile settings were changed.');
    }

    /**
     * Destroy the current users's account
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(DestroyAccount $request)
    {
        User::where('id', Auth::id())->delete();
        Auth::logout();

        return redirect('/');
    }
}
