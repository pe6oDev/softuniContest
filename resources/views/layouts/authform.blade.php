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
    {{--залената черта горе--}}
    <div id="topLine"></div>

    <div class="ui  container">
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


@endsection

@section('header')
    @include('includes.headers.header',['scripts'=>[asset('js/app.js'), asset('js/signUpForm.js')]])
@endsection

@push('header')
<style>
    body {
        background-color: #f3f3f3;
    }


    /*#topLine {*/
        /*background-color: #f20700;*/
        /*width: 100%;*/
        /*height: 3px;*/
    /*}*/

    #app{
        background: linear-gradient(60deg, rgba(255, 35, 0, 0.51), rgba(72, 146, 255, 0.5));
        height: 100%;
    }
</style>
@endpush