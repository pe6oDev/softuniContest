<?php
/**
 * Created by PhpStorm.
 * User: pepo
 * Date: 6/23/18
 * Time: 9:57 PM
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Calendar;
use Illuminate\Support\Facades\Auth;



class CalendarController
{
    /**
     * getWeek
     *
     * Зарежда дните от седмицата
     *
     * @return json
     */
    public function getWeek(Request $request)
    {
        $day = $request->get('day');
        $month = $request->get('month');
        $year = $request->get('year');
        $forOrBack = $request->get('forOrBack');

        $dates = Calendar::getDaysOfWeek($day, $month, $year, $forOrBack);

        return response()->json(['week' => $dates], 200);
    }


    /**
     * getMonths
     *
     * Зарежда страницата за календара
     *
     * @param int  $yearsDiff за след/преди колко години да се заредят месеци (пример: -1 = преди 1 година )
     *
     * @return view('calendar.calendar')
     */
    function getMonths($yearsDiff=0)
    {
        $user_id = Auth::user()->id;
//        $events = CalendarModel::where('event.user_id', $user_id)->where('deleted_at', null)->get();
        $dates = [];
        $daysWithEvents = [];
//        foreach ($events as $event) {
//            $e = $event->event;
//            if (array_key_exists($e['day'], $dates)) {
//                array_push($dates[$e['day']], $e['name']);
//            } else {
//                $dates[$e['day']] = [$e['name']];
//            }
//            $numberOfEvents = count($dates[$e['day']]);
//            $daysWithEvents[$e['day']] = $numberOfEvents;
//        }

        return view('calendar.calendar', ['dates' => $daysWithEvents, 'yearsDiff'=>$yearsDiff]);
    }
}