<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    @section('header')
        @include('includes.headers.header')
    @show


    <title>@yield('title')</title>


    @stack('scripts')
    @stack('header')


</head>
<body>

{{--тапета (с градиента)--}}
<div class="background">
    <div class="gradient"></div>
</div>

<main id="app">
    {{--page loader-a--}}
    <div  id="pageLoader" class="ui active dimmer">
        <div class="ui text loader">'зарежда се'...</div>
    </div>
    {{--side bar-a (профил меню и навигация)--}}
    @yield('sidebar')



    {{--Основната част от сайта--}}
    <div class="pusher ">
        @yield('main')
    </div>

</main>

@unless(isset($noVue) && $noVue)
<script src="{{asset('js/app.js')}}"></script>
@endunless
@include('includes.headers.headerSemantic')

</body>

</html>

