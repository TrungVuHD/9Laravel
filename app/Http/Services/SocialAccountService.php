<?php

namespace App\Http\Services;

use Laravel\Socialite\Contracts\User as ProviderUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\SocialAccount;
use App\User;

class SocialAccountService
{
    /**
     * Retrieve or create a new User
     *
     * @param ProviderUser $providerUser
     * @param $provider
     * @return User
     */
    public function findOrCreateAccount(ProviderUser $providerUser, $provider)
    {
        $account = $this->getSocialAccount($providerUser, $provider);
        if ($account) {
            return $account->user;
        }

        $user = $this->findOrNewUser($providerUser);
        $this->createSocialAccount($providerUser, $user->id, $provider);

        return $user;
    }

    /**
     * Retrieve a social account record
     *
     * @param ProviderUser $providerUser
     * @param $provider
     * @return mixed
     */
    protected function getSocialAccount(ProviderUser $providerUser, $provider)
    {
        return SocialAccount::where('provider', $provider)
            ->where('provider_user_id', $providerUser->getId())
            ->first();
    }

    /**
     * Retrieve a user model
     *
     * @param ProviderUser $providerUser
     * @return User
     */
    protected function findOrNewUser(ProviderUser $providerUser)
    {
        $user = User::where('email', $providerUser->getEmail())->first();

        if (!$user) {
            try {
                $user = $this->createUser($providerUser);
            } catch (\Exception $e) {
                return null;
            }
        }

        return $user;
    }

    /**
     * Create a user record
     *
     * @param ProviderUser $providerUser
     * @return User
     * @throws \Exception
     */
    protected function createUser(ProviderUser $providerUser)
    {
        $avatar_image = $this->storeAvatarImage($providerUser);
        $password = $this->createPassword();

        $user = new User();
        $user->username = $this->createUsername($providerUser->getEmail());
        $user->email = $providerUser->getEmail();
        $user->name = $providerUser->getName();
        $user->password = $password['hash'];
        $user->avatar_image = $avatar_image['basename'];

        if (!$user->save()) {
            throw new \Exception("The user data was not stored");
        }

        $this->sendUserCreationEmail($user, $password['raw']);

        return $user;
    }

    /**
     * Store the user image in the filesystem
     *
     * @param ProviderUser $providerUser
     * @return array
     */
    protected function storeAvatarImage(ProviderUser $providerUser)
    {
        $provider_avatar_location = $providerUser->getAvatar();
        $image_dir = storage_path('app' . DS . 'public' . DS . User::IMG_DIR);
        $provider_avatar = file_get_contents($provider_avatar_location);

        $image = ImageService::storeImageFile($provider_avatar, $image_dir);
        ImageService::multipleSizes($image['location'], ImageService::SIZES);

        return $image;
    }

    /**
     * Create a random user password
     *
     * @return array
     */
    protected function createPassword()
    {
        $data = [];
        $data['raw'] = str_random(20);
        $data['hash'] = Hash::make($data['raw']);

        return $data;
    }

    /**
     * Create a username out of an email address
     *
     * @param string $email
     * @return string
     */
    protected function createUsername(string $email)
    {
        $username = explode('@', $email)[0];
        $username = snake_case(str_slug($username));

        return $username;
    }

    /**
     * Email the user info
     *
     * @param User $user
     * @param $password
     */
    protected function sendUserCreationEmail(User $user, $password)
    {
        $email_data = [];
        $email_data['name'] = $user->name;
        $email_data['email'] = $user->email;
        $email_data['password'] = $password;

        Mail::send('emails.password', $email_data, function ($m) use ($user, $email_data) {
            $from_email = "no-reply@" . env('MAIL_FROM_ADDRESS');
            $m->from($from_email, '9Laravel');
            $m->to($email_data['email'], $email_data['name'])->subject('Your 9Laravel user password');
        });
    }

    /**
     * Persist a social account record
     *
     * @param ProviderUser $providerUser
     * @param int $user_id
     * @param string $provider
     * @return SocialAccount
     */
    protected function createSocialAccount(ProviderUser $providerUser, int $user_id, string $provider)
    {
        $account = new SocialAccount([
            'provider_user_id' => $providerUser->getId(),
            'user_id' => $user_id,
            'provider' => $provider
        ]);
        $account->save();

        return $account;
    }
}
