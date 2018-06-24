{{--Това views се ползва от calendar.blade view-то --}}
{{--Показва грид със всички дни от месеца (примерно от 1 до 30)--}}
{{--Като параметри получава:
    $freeSpaces:int - броя бразни места в началото на месеца (пример: ако първия ден от месеца е сряда - ще има 3 празни места /за неделя, понеделник и вторник/)
    $numberOfDays:int - боря на дните
    $month:int - месеца представен като int[1;12] (пример: Март = 3),
    $monthRelativeIndex:int - относителния номер на месеца (пример: ако сегашната дата е 3/ФЕВРУАРИ то месец Март ще е с относителен номер 2 ),
--}}

<?php
//theme e или зададената в бисквитка тема или идващата от базата
//ако и двете не съществуват $theme=null
$theme = \Illuminate\Support\Facades\Cookie::get('theme');
if(auth()->user()->theme){$theme=auth()->user()->theme;}
?>

<!-- Календар с дните от месеца -->
<div class="ui seven wide column segment" style="background-color: rgba(255,255,255,0.8)">

    <div class="ui seven column internally celled grid">
        <div class="ui  red row">
            {{--имената на дните от седмицата --}}
            @foreach(\App\Calendar::getWeekDaysShorts() as $day)
                <div class="ui column">
                    <b>{{$day}}</b>
                </div>
            @endforeach
        </div>
        @if($freeSpaces)
            <div class="ui row">
                @endif

                @for($freeSpace=0;$freeSpace<$freeSpaces;$freeSpace++)
                    <div class="ui column">

                    </div>
                @endfor





                @php
                    $newRow=$freeSpaces;
                @endphp

                @for($day=1;$day<=$numberOfDays;$day++)
                    @php
                        if($newRow<7){$newRow++;}
                        else{$newRow=1;}
                        $currentDay=(int)date('d');
                        $dayMonth = "" . $day . "/" . $month . "";
                    @endphp

                    @if($newRow==1)
                        <div  class="ui row ">
                            @endif
                            <a href="{{route('getDay', [$month, $day, $year])}}" class="ui column">

                                <span>{{$day}}</span>

                            </a>
                            @if($newRow==7 || $day==$numberOfDays)
                        </div>
                    @endif


                @endfor
            </div>
    </div>


