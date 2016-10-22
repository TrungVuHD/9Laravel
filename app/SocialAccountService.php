<?php

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\SocialAccount;

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

        		file_put_contents($image_location, file_get_contents($avatar));
        		
				$user = new User();
                $user->username = snake_case(str_slug($providerUser->getEmail()));
				$user->email = $providerUser->getEmail();
				$user->name = $providerUser->getName();
				$user->avatar_image = $image_file;

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
