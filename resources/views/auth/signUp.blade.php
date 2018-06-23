{{--Регистрационна форма --}}
@extends('layouts.authform', ['logIn' => false])

@section('form')
    @include('includes.forms.signUp')
    @lang('Вече имаш профил?')
    <br>
    <a href="{{route('getLogInForm')}}">@lang('Влез в профила си')</a>
@endsection

