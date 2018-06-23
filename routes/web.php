<?php

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (\Illuminate\Http\Request $request) {
    if(Auth::user()){
        return app('App\Http\Controllers\CalendarController')->getMonths($request);
    } else {
        return view('welcome');
    }
})->name('home');




Route::get('/login', function () {
    return view('dashboard');
})->name('login');




Route::namespace('Auth')->group(function () {

    Route::middleware('guest')->group(function (){

        Route::post('sign/up','RegisterController@register')->name('signUp');

        Route::post('log/in', 'LoginController@login')->name('logIn');

    });


    Route::get('log/in/google', 'GoogleController@redirectToProvider')->name('googleLogIn');

    Route::get('log/in/google/callback', 'GoogleController@handleProviderCallback');

    Route::get('log/in/form', 'LoginController@getLogIn')->name('getLogInForm');

    Route::get('sign/up/form', 'RegisterController@getSignUp')->name('getSignUpForm');

    Route::middleware('auth')->group(function (){



        Route::get('log/out','LoginController@logout')->name('user.logout');
    });
});



Route::prefix('user')->group(function () {

    //Проверява дали email-a е зает (за front-end валидацията на sing up формата)
    Route::post('check/email', 'UserController@checkEmail')->name('checkEmailUnique');

    Route::middleware('auth')->group(function (){

        Route::post('more/info', 'UserController@moreInfo');

        Route::post('change/pass','UserController@changePassword')->name('changePass');

        Route::post('set/pass','UserController@setPassword')->name('setPass');

    });

});

Route::middleware('auth')->group(function (){

    Route::get('dashboard', function (){
        return view('dashboard');
    })->name('dashboard');

    Route::get('getWeekDays', 'CalendarController@getWeek')->name('getCalendarWeek');

    Route::get('week', 'CalendarController@getWeekView')->name('week');

    Route::get('1',function(){})->name('getDay');//TODO::remove
    Route::get('/month/{yearsDiff?}', 'CalendarController@getMonths')->name('calendar.month');

});
