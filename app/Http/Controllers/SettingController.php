<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\SocialAccount;
use App\User;

class SettingController extends Controller
{
    protected $countries;
    protected $user;

    public function __construct()
    {
        $this->countries = $this->getCountries();
        $this->user = Auth::user();
    }

    public function geCountries()
    {
        $location = storage_path('app/countries.txt');
        $countries = file_get_contents($location);
        return explode(', ', $countries);
    }

    public function showAccount()
    {
        return view('settings.account', ['user' => $this->user]);
    }

    public function showPassword()
    {
        return view('settings.password');
    }

    public function showProfile()
    {
        return view('settings.profile', ['countries' => $this->countries, 'user' => $this->user]);
    }

    public function showMyProfile()
    {
        return view('settings.my-profile');
    }

    public function storeAccount(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:255',
            'email' => 'required|email',
            'show_nsfw' => 'required|integer',
        ]);

        $user = Auth::user();

        $user->username = str_slug($request->username);
        $user->email = $request->email;
        $user->show_nsfw = $request->show_nsfw;
        $user->show_upvote = $request->show_upvote;

        $user->save();

        return redirect()
                ->back()
                ->with('status', 'Account settings were saved');
    }

    public function storePassword(Request $request)
    {
        $user = Auth::user();
        $hashedPassword = $user->password;

        $this->validate($request, [
            'old_password' => 'required|max:255',
            'new_password' => 'required|max:255',
            'repeat_new_password' => 'required|max:255'
        ]);

        // check to see if the passwords match...
        if (Hash::check($request->old_password, $hashedPassword)) {
            if ($request->new_password === $request->repeat_new_password) {
                $new_password = Hash::make($request->new_password);

                $user->password = $new_password;

                $user->save();

                return redirect()
                        ->back()
                        ->with('status', 'The password has been changed');
            }
        }

        return redirect()
                ->back()
                ->withErrors('The old password doesn\'t match the password you entered.');
    }

    public function storeProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'gender' => 'required|integer',
            'avatar_image' => 'image',
            'country' => 'required|max:100',
            'description' => 'max:255',
            'birthday_year' => 'integer|max:9999',
            'birthday_month' => 'integer|max:12',
            'birthday_day' => 'integer|max:31',
        ]);

        $user = Auth::user();

        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->country = $request->country;
        $user->description = $request->description;
        $user->birthday_year = $request->birthday_year;
        $user->birthday_month = $request->birthday_month;
        $user->birthday_day = $request->birthday_day;

        if ($request->hasFile('avatar_image') && $request->file('avatar_image')->isValid()) {
            // save the image to disk
            $image_name = str_random(20);
            $image_name .= '.'.$request->avatar_image->getClientOriginalExtension();

            $avatar_image = $request
                ->avatar_image
                ->move('img/avatars', $image_name);

            // save the image to database(model)
            $user->avatar_image = $image_name;

            $avatar_location = base_path().DS.'public'.DS.$avatar_image;

            // resize the image
            $img = Image::make($avatar_location);
            $img->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($avatar_location, 70);
        }

        $user->save();

        return redirect()
                ->back()
                ->with('status', 'Profile settings were changed.');
    }

    public function destroy(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->firstOrFail();
        $user->delete();

        Auth::logout();

        return redirect('/');
    }
}
