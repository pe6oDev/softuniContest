<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Socialite;
use App\Http\Controllers\Controller;
use App\SocialAuth\SocialAccountService;


class GoogleController extends Controller
{
    /*
     |-----------------------------------------------
     | GoogleController
     |-----------------------------------------------
     |
     | Контролер за логин/регистрация с google акаунт
     |
     */


    /**
     * Препраща потребителя към страницата на google за login/регистрация
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Получава информацията за потребителя от Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();
        $socialAccountService = new SocialAccountService('google');
        $user = $socialAccountService->createOrGetUser($user);

        auth()->login($user);
        return redirect()->route('dashboard');

    }

    /**
     * getLogIn
     *
     * показва формата за вход
     * @return view
     */
    public function getLogIn()
    {
        return view('auth.logIn');
    }
}
