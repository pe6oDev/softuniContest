{{-- Layout за страниците за sing up и log in --}}

@extends('layouts.welcome')

@section('title')
    @if($logIn == true)
        @lang('Влез')
    @else
        @lang('Регистрирай се безплатно')
    @endif
@endsection

@section('main')
    <div class="background">
        <div class="ui  container ">
            <br><br><br><br><br><br><br>
            {{--Контейнер за формата--}}
            <div class="ui grid one column center aligned stackable ">
                <div class="ui seven wide column">
                    <div class="ui segment">
                        @yield('form')
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('header')
    @include('includes.headers.header',['scripts'=>[asset('js/app.js'), asset('js/signUpForm.js')]])
@endsection

@push('header')
<style>
    body {
        background-color: #f3f3f3;
    }


</style>
@endpush