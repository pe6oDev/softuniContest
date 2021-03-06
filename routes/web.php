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




Route::get('/login',  'Auth\LoginController@getLogIn')->name('login');




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

    Route::get('day/{day}/{month}/{year}','CalendarController@getDay')->name('getDay');

    Route::get('getWeekEvents', function (){
        return [];
    })->name('getWeekEvents'); //TODO implement

    Route::get('getEvents', 'CalendarController@getEvents')->name('getEvents');

    Route::post('postEvent', 'CalendarController@postEvent')->name('postEvent');

    Route::get('getRestDays', 'CalendarController@getRestDays')->name('getRestDays');

    Route::get('getNameDays', 'CalendarController@getNameDays')->name('getNameDays');

    Route::get('/month/{yearsDiff?}', 'CalendarController@getMonths')->name('calendar.month');

    Route::middleware('admin')->group(function(){
        Route::get('users','Admin\AdminController@getUsers');

        Route::post('users/ajax','Admin\AdminController@getUsersAjax')->name('usersAjax');

        Route::post('users/change/type', 'Admin\AdminController@postChangeType')->name('changeUserType');

        Route::get('daySettings', 'Admin\AdminController@getDaySettings')->name('getDaySettings');

        Route::post('postRestDay', 'CalendarController@postRestDay')->name('postRestDay');

        Route::post('deleteRestDay', 'CalendarController@deleteRestDay')->name('deleteRestDay');

        Route::get('name/days', 'Admin\AdminController@getNameDaySettings')->name('getNameDaysSettings');

        Route::post('postNameDay', 'CalendarController@postNameDay')->name('postNameDay');

        Route::post('deleteNameDay', 'CalendarController@deleteNameDay')->name('deleteNameDay');

        Route::get('promotion/days', 'Admin\AdminController@getPromotionsSettings')->name('getPromotionsSettings');
    });



});
