{{--  Страницата за изглед "седмица" на календара с събития  --}}

@extends('layouts.welcome')


@php
    if(\Illuminate\Support\Facades\App::getLocale() == "bg"){
        $months = \App\Calendar::monthsBg;
        $weekDays = \App\Calendar::weekDaysBg;
    } else {
        $months = \App\Calendar::monthsEn;
        $weekDays = \App\Calendar::weekDaysEn;
    }
    $sunday = $weekDays[0];
    array_splice($weekDays, 0, 1);
    $weekDays[6] = $sunday;
@endphp

@section('title')
    @lang('Седмица')
@endsection

@section('main')
    <div class="ui one column center aligned stackable grid">
        <!-- Бутон за връщане назад -->
        <div class="ui  row" >
            <div class="ui sixteen wide right aligned column">
                <a href="{{route('calendar.month')}}">
                    <div class="ui icon  red button" style="margin-top: 0.5cm; margin-right: 0.5cm">
                        @lang('назад')
                        <i class="ui right arrow icon"></i>
                    </div>
                </a>

            </div>
        </div>
        <!-- Бутон за изглед месец -->
        <div class="ui  row" >
            <div class="ui sixteen wide right aligned column">
                <a href="{{route('calendar.month')}}">
                    <div class="ui icon  blue button" style="margin-top: 0.5cm; margin-right: 0.5cm">
                        @lang('Месец')
                        <i class="ui calendar alternate icon"></i>
                    </div>
                </a>
            </div>
        </div>
        <!-- Бутони за смяна на седмицата -->
        <div class="ui row  ">
            <i class="ui blue chevron circle left icon large toPreviousWeek"></i> &nbsp; &nbsp;
            <div class="header"><b id="startDate"></b>-<b id="endDate"></b></div> &nbsp; &nbsp;
            <i class="ui blue chevron circle right icon large toNextWeek"></i> &nbsp; &nbsp;
        </div>
        <!-- Информационни съобщения -->
        <div class="ui row">
            <div class="ui success message" id="editMessage" style="display: none">Събитието беше редактирано успешно!
            </div>
            <div class="ui success message" id="deleteMessage" style="display: none">Събитието беше изтрито успешно!
            </div>
        </div>
        <!-- Дни от седмицата -->
        <div class="ui row ">
            @for($i=0; $i < 7; $i++)
                <div class="five wide column">
                    <div onclick="goToDay({{$i}})" class="ui blue button dayButtons">{{$weekDays[$i]}}</div>
                </div>
            @endfor
        </div>
        <!-- Сегменти за дните от седмицата -->
        <div class="ui row">
            @for($i=0; $i < 7; $i++)
                <div id="daySegment{{$i}}" class="two wide column">
                    @include('includes.wholeDayEvent',[
                'id'=>$i,
                'color'=>App\EventsColors::colors['promotion'],
                'header'=>'Промоция на телевизори',
                'description'=>'Descriptio long verry long'
                ])
                    <a id="weekDay{{$i}}" class="weekHeaders" href="">
                        <h3 style="text-decoration: none">{{$weekDays[$i]}}</h3>
                        <span id="dayHeaderDate{{$i}}"></span>
                    </a>
                    <div class="ui segment eventHolders" id="eventsHolder{{$i}}" style="padding-bottom: 65px">
                        <div id="first-{{$i}}" class="ui horizontal divider" style="display: none;"></div>
                        @for($k=0; $k <= 23; $k++)
                            <div id="{{$k}}-{{$i}}" class="ui horizontal divider"
                                 style="@if($k != 0) margin-top: 60px @else margin-top: 15px @endif">
                                @if($k < 10)
                                    <span style="color: darkgray">0{{$k}}:00</span>
                                @else
                                    <span style="color: darkgray">{{$k}}:00</span>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
            @endfor
        </div>
        <a href="#" id="floatingButton" class=" ui red button huge circular icon">
            <i class="ui add icon"></i>
        </a>
    </div>
    <br><br>
@endsection

@section('header')
    @include('includes.headers.header',[
    'scripts'=>[
        asset('js/calendarWeek.js'),
        asset('js/sideBar.js'),
    ]])
    <script>
        var hideSidebar = true;

        var changeWeekUrl = "{{route('getCalendarWeek')}}";
        var getWeekEventsUrl = "{{route('getWeekEvents')}}";
        {{--var deleteEventUrl = "{{route('deleteEvent')}}";--}}
        var token = "{{Session::token()}}";
        var months = {!!  json_encode(\App\Calendar::getMonths())!!};
    </script>

    <style>
        h3,.weekHeaders, .header{
            color:white;
        }
    </style>

@endsection

@push('header')
<link rel="stylesheet" type="text/css" href="{{ asset('css/week.css') }}">
@endpush

@section('sidebar')
    @include('includes.profile.sidebar')
@endsection

