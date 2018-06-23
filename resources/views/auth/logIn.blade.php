{{--Логин форма--}}
@extends('layouts.authform', ['logIn' => true])

@section('form')
    @include('includes.forms.signUp',['logIn'=>true])
   @lang('Нямате регистрация?')
    <br>

    <a href="{{route('getSignUpForm')}}">@lang('Създайте профил')</a>
@endsection

