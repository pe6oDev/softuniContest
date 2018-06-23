<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    /*
     |--------------------------------------------------------------------------
     | User Controller
     |--------------------------------------------------------------------------
     |
     | Контролер за дейностите свързани с потребителите
     | login ; sign up
     | персонализация и др
     |
     */


    /**
     * checkEmail
     *
     * проверява дали email-a e свободен,
     * ползва се при регистрацията на потребители
     *
     * вика се от
     * route('checkEmailUnique')
     * method:POST
     *
     * използва се в js/signUpForm.js
     *
     * @param Request $request
     *          $request->email : email
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function checkEmail(Request $request)
    {
        if (User::where('email', $request->email)->exists()) {
            return response('', 300);
        }
        return response('', 200);
    }

    /**
     * changePassword
     *
     * сменя паролатоа с нова (newPass) , ако е подадена правилна стара (oldPass)
     *
     * вика се от
     * route('changePass')
     * method:POST
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function changePassword(Request $request)
    {
        //валидация
        $this->validate($request, [
            'oldPass' => 'required|min:6|password',
            'newPass' => 'required|min:6|confirmed',
        ]);
        //хеширане  и записване на новата парола в базата
        Auth::user()->password = Hash::make($request['newPass']);
        Auth::user()->save();

        return response(200);

    }


    /**
     * setPassword
     *
     * изполва се за задаване на парола за потребителите, които нямат така
     * някои потребители са регистрирани чре google акаунт и следователно нямат парола
     *
     * вика се от
     * route('setPass')
     * method:POST
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function setPassword(Request $request)
    {
        $this->validate($request, [
            'newPass' => 'required|min:6|confirmed',
        ]);
        Auth::user()->password = Hash::make($request['newPass']);
        Auth::user()->save();

        return response(200);
    }

    public  function moreInfo(Request $request){
        Auth::user()->more_info = $request->info;
        Auth::user()->save();
        return response(200);
    }

}
