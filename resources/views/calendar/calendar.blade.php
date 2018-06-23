{{--това е началното view за календара--}}
{{--с иброени месеци--}}

@extends('layouts.welcome')

@section('title')
    @lang('Календар')
@endsection

@section('main')

    @php
        //брой месеци, които да показва
            $numberOfMonths=11;
            $currentDay = date('j');
            $currentMonth = date('n')
    @endphp


    {{--id="touchzone" - ползва се от leftRightGesture.js--}}
    <div id="touchzone" class="ui one column center aligned stackable grid">
        <div class="ui  row" >
            <div class="ui sixteen wide right aligned column">
                <a href="{{route('dashboard')}}">
                    <div class="ui icon  green button" style="margin-top: 0.5cm; margin-right: 0.5cm">
                        @lang('назад')
                        <i class="ui right arrow icon"></i>
                    </div>
                </a>

            </div>

        </div>
        <div class="ui  row" >
            <div class="ui sixteen wide right aligned column">
                <a href="{{route('week')}}">
                    <div class="ui icon  blue button" style="margin-top: 0.5cm; margin-right: 0.5cm">
                        @lang('Седмица')
                        <i class="ui calendar alternate icon"></i>
                    </div>
                </a>
            </div>
        </div>
    {{--върти цикъл за имената на месеците --}}
    @for($i=$yearsDiff; $i<=$numberOfMonths+$yearsDiff; $i++)
        <!-- Име на месец -->
            <div {{$i!=0?'style=display:none':''}}
                 id="monthName{{$i}}" class="ui row  monthName">
                <div
                        data-month="{{$i}}" class="ui column ">
                @unless($i!=0)
                    <!-- Стрелка към предишния месец -->
                        <i style="display: none" class="ui  icon large"></i>
                        @else
                            <i class="ui green chevron circle left icon large toPreviousMonth"></i> &nbsp; &nbsp;
                            @endunless
                            <h3 class="ui  icon   header">
                                {{\App\Calendar::getMonths(date('n') + $i)}}
                            </h3>

                            <!-- Стрелка към следващия месец -->
                            @unless($i==$numberOfMonths)
                                &nbsp; &nbsp; <i class="ui green chevron circle right icon large toNextMonth"></i>
                            @endunless

                </div>

            </div>

        @php
            $monthName = App\Calendar::getMonths(date('n') + $i);
            $month = array_search($monthName, App\Calendar::getMonthsNumber());
        @endphp
        <!-- Календар с дните от месеца -->
            <div {{$i!=0 ?'style=display:none':''}}  class="ui row month" id="month{{$i}}">

                @include('calendar.month',[
                'freeSpaces'=>\App\Calendar::getFirstDayOfWeek($i),
                'numberOfDays'=>\App\Calendar::getDaysMonth($i),
                'month'=>$month,
                'monthRelativeIndex'=>$i,
                'dates' => $dates
                ])

            </div>
        @endfor
    </div>


@endsection

@section('header')
    @include('includes.headers.header',[
    'scripts'=>[
        asset('js/changeMonth.js'),
        asset('js/sideBar.js'),
        asset('js/leftRightGesture.js')
    ]])
@endsection

@push('header')
<script>
    var monthOrDay='month';
</script>
@endpush

@section('sidebar')
    @include('includes.profile.sidebar')
@endsection