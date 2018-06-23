{{--  Страницата за изглед "ден" на календара с събития  --}}

<?php
$theme = theme();
?>

@extends('layouts.welcome')
@inject('calendar', 'App\Calendar')


@section('title')
    {{$day}} {{$calendar->getMonths($month)}}


@endsection

@php
    $routePrevDay=route('getDay',[$carbonDt->subDay()->month,$carbonDt->day]);
       $routeNextDay=route('getDay',[$carbonDt->addDays(2)->month,$carbonDt->day]);
       $dayMonth = "" . $day . "/" . $month . "";
@endphp

@section('main')
    <br>
    <div  id="touchzone" class="ui center aligned stackable grid">
        <div class="ui  row" >
            <div class="ui sixteen wide right aligned column">
                <a href="{{route('calendar.month')}}">
                    <div class="ui icon  green button" style="margin-right: 0.5cm">
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
                        <i class="ui green chevron circle left icon medium toPreviousMonth"></i> &nbsp;
                    </a>

                @endunless
                {{$day}} {{$calendar->getMonths($month)}}
                {{--стрелка за следващ ден--}}
                <a href="{{$routeNextDay}}">
                    <i class="ui green chevron circle right icon medium toPreviousMonth"></i> &nbsp;
                </a>

            </h2>
        </div>
        <div class="ui row" style="margin-top: 5px">
            <br>
            <div id="eventButton" class="ui green  icon button">
                <i class="ui plus icon"></i> @lang('Добави събитие')
            </div>
        </div>
        <div class="ui row" style="margin-top: 10px">
            <br>
            <div id="groceryButton" class="ui green  icon button">
                <i class="ui plus icon"></i> @lang('Създай списък')
            </div>
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
            @if(!empty($groceries->all()))
                <div class="four wide column">
                    <div class="ui center aligned grid">
                        @foreach($groceries as $item)
                            <div class="ui stretched row" style="margin-bottom: 0.5cm">
                                <div onclick='viewLoad("{{$item->_id}}")' class="ui segment" style="width: 85%">
                                    {{--Колко са чекнатите--}}
                                    @php
                                        $products = collect($item->products);
                                        $total = $products->count();
                                        $checked = $products->reject(function ($value) {
                                            return !$value['checked'];
                                        })->count();
                                    @endphp
                                    <h6 style="width:100%;text-align: right; margin-top: 0; margin-bottom: -7px">{{$checked}}
                                        /{{$total}}</h6>
                                    {{--Името на списъка--}}
                                    <h4 style="margin-top: 0">{{isset($item->name) && $item->name ? $item->name : $item->date}}</h4>
                                    <div class="ui divider"></div>
                                    @php
                                        if(sizeof($item->products) > 3){
                                            $stop = 3;
                                        } else {
                                            $stop = sizeof($item->products);
                                        }
                                    @endphp
                                    @for($i = 0; $i < $stop; $i++)
                                        <p>{{$item->products[$i]['name']}}</p>
                                    @endfor
                                </div>
                            </div>
                        @endforeach
                        <div class="ui row">
                            {{$groceries->links()}}
                        </div>
                    </div>
                </div>
            @endif
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
        @include('includes.modals.eventModal', ['id' => 'postModal', 'type' => 'Създаване на събитие'])
        @include('includes.modals.eventModal', ['id' => 'editModal', 'type' => 'Редактиране на събитие'])
        @include('includes.modals.groceryModal', ['id' => 'postGroceryModal', 'date' => $dayMonth, 'dayId' => 'dayPost', 'monthId' => 'monthPost', 'type' => 'Създаване на списък'])
        @include('includes.modals.groceryModal', ['id' => 'editGroceryModal', 'date' => $dayMonth, 'dayId' => 'dayEdit', 'monthId' => 'monthEdit', 'type' => 'Редактиране на списък'])
        @include('includes.modals.viewGroceryModal', ['origin' => 'calendar'])
        @include('includes.modals.yes_noModal', ['id' => 'deleteModal', 'header' => 'Изтриване на събитие', 'content' => 'Наистина ли искате да изтриете това събитие?'])
    </div>
    <br><br><br><br>
@endsection

@push('scripts')
<script>
    var hideSidebar = true;

    postEventUrl = "{{route('postEvent')}}";
    getEventsUrl = "{{route('getEvents')}}";
    getOneEventUrl = "{{route('getOneEvent')}}";
    deleteEventUrl = "{{route('deleteEvent')}}";
    editEventUrl = "{{route('editEvent')}}";
    dayMonth = "{{$dayMonth}}";
    token = "{{Session::token()}}";
    //за сменянето на дни със слайдване на пръста
    var monthOrDay='day';
    var hasPrevDay='{{!($day<=$currentDay && $monthInt==0)}}';
    var routePrevDay="{{$routePrevDay}}";
    var routeNextDay="{{$routeNextDay}}";
</script>
<script src="{{asset('js/leftRightGesture.js')}}"></script>
<script src="{{asset('js/day.js')}}"></script>
<script src="{{asset('js/sideBar.js')}}"></script>

@endpush

@push('header')
<link rel="stylesheet" type="text/css" href="{{ asset('css/day.css') }}">

<style>
    @unless($theme =='dark')
    #eventsHolder .eventBox{
        background-color:rgb(33,169,39,0.1);
        background-color:rgba(33,169,39,0.1);
    }
    @else
     #eventsHolder .eventBox{
        background-color: rgba(255, 255, 255, 0.1);
        background-color:rgba(255, 255, 255,0.1);
    }
    @endunless

</style>

@endpush


@section('sidebar')
    @include('includes.profile.sidebar')
@endsection