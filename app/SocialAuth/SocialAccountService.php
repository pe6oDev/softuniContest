<?php

namespace App\SocialAuth;

use Laravel\Socialite\Contracts\User as ProviderUser;
use App\SocialAuth\SocialAccount;
use App\User;

/*
 |---------------------------------------------------------
 | SocialAccountService
 |---------------------------------------------------------
 |
 | Регистрира или логва потребител чрез google id
 |
 | работи с mySql
 |
 */

class SocialAccountService
{
    private $provider = 'google';

    function __construct($provider)
    {
        $this->provider = $provider;
    }

    public function createOrGetUser($providerUser)
    {


        $account = SocialAccount::where('provider', $this->provider)
            ->where('provider_user_id', $providerUser->getId())
            ->first();

        if ($account) {
            $account->user->save();
            return $account->user;
        } else {
            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $this->provider
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;

        }

    }
}
