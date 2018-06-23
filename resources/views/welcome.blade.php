@extends('layouts.welcome')
@section('title','ImeFamilia')

@section('main')

    {{--Навигация--}}
    <div style="background-color: white;border-bottom: 1px solid rgba(34,36,38,.15);"
         class="ui top fixed text big  menu">
        <div id="menuContainer" class="ui  container">
            <img class="postBankLogo" src="https://www.postbank.bg/web/images/logo-bg.svg" alt="">
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
    @for($i=0;$i<=16;$i++)
        <br>
    @endfor
    <div class="ui container" >
        <div class="ui two column grid internally celled stackable">
            {{--Сменящи се вдъхновяващи хедъри--}}
            <div class="ui column">
                <div class="ui text container " id="inspirations">
                    <div id="header1" class="ui huge header">Предлагаш нещо ? </div>

                    <div id="header2" class="ui huge  header">Или пък търсиш ?</div>

                    <div id="header3" class="ui huge  header">Не намираш <br>правилната общност ? </div>

                    <div id="header4" class="ui huge  header">ТheCommunity  helper <br>- твоята общност</div>

                </div>
            </div>
            {{--регистрационна форма--}}
            <div class="ui column">
                <div class="ui container">
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
        @for($i=0;$i<=14;$i++)
            <br>
        @endfor



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



