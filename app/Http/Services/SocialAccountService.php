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
        $avatar = $providerUser->getAvatar();
        $image_dir = base_path().DS.'public'.DS.'img'.DS.'avatars'.DS;
        $image_file = str_random(20).'.jpeg';
        $image_location = $image_dir.$image_file;

        if (!file_exists($image_dir)) {
            mkdir($image_dir);
        }

        file_put_contents($image_location, file_get_contents($avatar));

        $password = str_random(20);
        $hashed_password = Hash::make($password);

        $user = new User();
        $user->username = $this->createUsername($providerUser->getEmail());
        $user->email = $providerUser->getEmail();
        $user->name = $providerUser->getName();
        $user->password = $hashed_password;
        $user->avatar_image = $image_file;

        if (!$user->save()) {
            throw new \Exception("The user data was not stored");
        }

        $this->sendUserCreationEmail($user, $password);

        return $user;
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
