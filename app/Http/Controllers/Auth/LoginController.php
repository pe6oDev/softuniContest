<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Sarfraznawaz2005\VisitLog\Facades\VisitLog;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * getLogIn
     *
     * показва формата за вход
     * @return view
     */
    public function getLogIn()
    {
        if (Auth::user() == null) {
            return view('auth.logIn');
        } else {
            return route('getUsersAdmin');
        }
    }

    /**
     * Where to redirect users after login.
     *
     *
     */
    protected function redirectTo()
    {
        return route('dashboard');

    }
}
