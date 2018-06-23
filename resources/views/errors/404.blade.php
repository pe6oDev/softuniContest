@extends('layouts.welcome')

@section('title')
    404
@endsection


@section('main')
    <br><br><br><br><br><br><br><br>
    <div class="ui center aligned stackable grid">
        <div class="ui row">
            <div class="eight wide column">
                <div class="ui negative message">

                    <div class="header">
                        @lang('Грешка') 404
                    </div>
                    <p>@lang('Страницата не съществува')</p>

                </div>
            </div>
        </div>
        <div class="ui row">
            <div class="eight wide column">
                <a href="{{route('home')}}"><div class="ui green button">@lang('Върни се в началото')</div></a>
            </div>
        </div>
    </div>
@endsection