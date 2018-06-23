@extends('layouts.welcome')
@section('title','ImeFamilia')

@section('main')

        {{--Навигация--}}
        <div id="menuContainer"
             class="ui top fixed text big  menu">
            <div  class="ui  container">
                <img class="postBankLogo" src="{{asset('images/logo.svg')}}" alt="">
                {{--<p id="logoText" class="active item">Пощенска банка календар</p>--}}
                <div class="right menu">
                    <a  href="{{route('getLogInForm')}}" class="item">
                        <span class="ui blue button">
                            влез
                        </span>
                    </a>
                    <a href="{{route('getSignUpForm')}}" class="item">регистрирай се</a>
                </div>
            </div>



        </div>
        @for($i=0;$i<=12;$i++)
            <br>
        @endfor

            <div class="ui one column grid centered">
                {{--регистрационна форма--}}
                <div class="ui six wide column">
                    <div class="ui segment raised  ">
                        <br>
                        <div class="ui three column center aligned grid stackable">
                            <div class="ui three wide column"></div>
                            <div class="ui ten wide column">
                                @include('includes.forms.signUp')
                            </div>
                            <div class="ui three wide column"></div>
                        </div>
                    </div>
                </div>
            </div>








@endsection

@section('header')

    @include('includes.headers.header',[
                'scripts'=>[
                asset('js/welcome.js'),
                asset('js/app.js'),
                asset('js/signUpForm.js')
                ],
                'styles'=>[
                    asset('css/welcome.css'),
                    "https://fonts.googleapis.com/css?family=Raleway:100,600",
                    "https://fonts.googleapis.com/css?family=Open+Sans"
                ]])



@endsection
