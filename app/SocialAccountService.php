<?php

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\SocialAccount;
use App\User;

class SocialAccountService
{
    
    public function createOrGetUser(ProviderUser $providerUser, $provider)
    {
    	define('DS', DIRECTORY_SEPARATOR);

        Auth::logout();

    	$account = SocialAccount::where('provider', $provider)
    		->where('provider_user_id', $providerUser->getId())
    		->first();

    	if($account) 
    	{
    		return $account->user;
    	} 
    	else 
    	{
			$user = User::where('email', $providerUser->getEmail())->first();

			if(!$user) {

				$avatar = $providerUser->getAvatar();
				$image_data = file_get_contents($avatar);
        		
        		$image_dir = base_path().DS.'public'.DS.'img'.DS.'avatars'.DS;
        		$image_file = str_random(20).'.jpeg';
				$image_location = $image_dir.$image_file;

                if(!file_exists($image_dir))
                {
                    mkdir($image_dir);
                }

        		file_put_contents($image_location, file_get_contents($avatar));
        		
                $password = str_random(20);
                $hashed_password = Hash::make($password);

				$user = new User();

                $username = explode('@', $providerUser->getEmail())[0];
                $username = snake_case(str_slug($username));

                $user->username = $username;
				$user->email = $providerUser->getEmail();
                $user->name = $providerUser->getName();
                $user->password = $hashed_password;
				$user->avatar_image = $image_file;

                $email_data = [];
                $email_data['name'] = $user->name;
                $email_data['email'] = $user->email;
                $email_data['password'] = $password;

                Mail::send('emails.password', $email_data, function ($m) use ($user, $email_data) {
                    $m->from('no-reply@9laravel.superbrackets.com', '9Laravel');

                    $m->to($email_data['email'], $email_data['name'])->subject('Your Password!');
                });

				$user->save();
			}

    		$account = new SocialAccount([
    			'provider_user_id' => $providerUser->getId(),
    			'user_id' => $user->id,
    			'provider' => $provider
			]);
			$account->save();

			return $user;
    	}
    }
}
