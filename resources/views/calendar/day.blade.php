{{--  Страницата за изглед "ден" на календара с събития  --}}


@extends('layouts.welcome')
@inject('calendar', 'App\Calendar')


@section('title')
    {{$day}} {{$calendar->getMonths($month)}}


@endsection

@php

    $routePrevDay=route('getDay',[$carbonDt->subDay()->month,$carbonDt->day,$carbonDt->month ==12 ?$year+1:  $year]);
    $routeNextDay=route('getDay',[$carbonDt->addDays(2)->month,$carbonDt->day, $carbonDt->month ==1 ?$year-1:  $year]);
    $dayMonth = "" . $day . "/" . $month . "";
@endphp

@section('main')
    <br>
    <div id="touchzone" class="ui center aligned stackable grid">
        <div class="ui  row">
            <div class="ui sixteen wide right aligned column">
                <a href="{{route('calendar.month')}}">
                    <div class="ui icon  blue button" style="margin-right: 0.5cm">
                        @lang('назад')
                        <i class="ui right arrow icon"></i>
                    </div>
                </a>

            </div>

        </div>
        <div class="ui row">
            <h2 id="header" class="center aligned header ">

                @unless($day<=$currentDay && $monthInt==0)
                    <a href="{{ $routePrevDay}}">
                        <i class="ui blue chevron circle left icon medium toPreviousMonth"></i> &nbsp;
                    </a>

                @endunless
                <span style="color: white"> {{$day}} {{$calendar->getMonths($month)}}</span>
                {{--стрелка за следващ ден--}}
                <a href="{{$routeNextDay}}">
                    <i class="ui blue chevron circle right icon medium toPreviousMonth"></i> &nbsp;
                </a>

            </h2>
        </div>

        <div class="ui row">
            <div class="ui success message" id="postMessage" style="display: none">Събитието беше записано успешно!
            </div>
            <div class="ui success message" id="editMessage" style="display: none">Събитието беше редактирано успешно!
            </div>
            <div class="ui success message" id="deleteMessage" style="display: none">Събитието беше изтрито успешно!
            </div>
        </div>
        <div class="ui row">
            <div class="ui ten wide column">
                <div class="ui segment" id="eventsHolder" style="padding-bottom: 65px">
                    <div id="first" class="ui horizontal divider" style="display: none;"></div>
                    @for($i=0; $i <= 23; $i++)
                        <div id="{{$i}}" class="ui horizontal divider"
                             style="@if($i != 0) margin-top: 60px @else margin-top: 15px @endif">
                            @if($i < 10)
                                <span style="color: darkgray">0{{$i}}:00</span>
                            @else
                                <span style="color: darkgray">{{$i}}:00</span>
                            @endif

                        </div>
                    @endfor
                </div>
            </div>
        </div>
        {{--@include('includes.modals.eventModal', ['id' => 'postModal', 'type' => 'Създаване на събитие'])--}}
        {{--@include('includes.modals.eventModal', ['id' => 'editModal', 'type' => 'Редактиране на събитие'])--}}
        {{--@include('includes.modals.yes_noModal', ['id' => 'deleteModal', 'header' => 'Изтриване на събитие', 'content' => 'Наистина ли искате да изтриете това събитие?'])--}}

        <div id="floatingButton" class=" ui red button huge circular icon">
            <i class="ui add icon"></i>
        </div>

    </div>
    <br><br><br><br>
@endsection

@push('scripts')
<script>
    var hideSidebar = true;

    {{--postEventUrl = "{{route('postEvent')}}";--}}
            {{--getEventsUrl = "{{route('getEvents')}}";--}}
            {{--getOneEventUrl = "{{route('getOneEvent')}}";--}}
            {{--deleteEventUrl = "{{route('deleteEvent')}}";--}}
            {{--editEventUrl = "{{route('editEvent')}}";--}}
            {{--dayMonth = "{{$dayMonth}}";--}}
        token = "{{Session::token()}}";
    //за сменянето на дни със слайдване на пръста
    var monthOrDay = 'day';
    var hasPrevDay = '{{!($day<=$currentDay && $monthInt==0)}}';
    var routePrevDay = "{{$routePrevDay}}";
    var routeNextDay = "{{$routeNextDay}}";
</script>
<script src="{{asset('js/leftRightGesture.js')}}"></script>
<script src="{{asset('js/day.js')}}"></script>
<script src="{{asset('js/sideBar.js')}}"></script>

@endpush

@push('header')
<link rel="stylesheet" type="text/css" href="{{ asset('css/day.css') }}">
@endpush


@section('sidebar')
    @include('includes.profile.sidebar')
@endsection