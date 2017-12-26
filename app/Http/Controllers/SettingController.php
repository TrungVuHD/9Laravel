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

        $this->countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
        $this->user = Auth::user();
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

    public function destroyFacebook()
    {
        $account = SocialAccount::where('user_id', Auth::user()->id)
            ->where('provider', 'facebook')
            ->first();

        if ($account) {
            $account->delete();
        }

        return redirect()
            ->back()
            ->with('status', 'Facebook is disconnected');
    }

    public function destroyGoogle()
    {
        $account = SocialAccount::where('user_id', Auth::user()->id)
            ->where('provider', 'google')
            ->first();

        if ($account) {
            $account->delete();
        }

        return redirect()
            ->back()
            ->with('status', 'Google is disconnected');
    }
}
