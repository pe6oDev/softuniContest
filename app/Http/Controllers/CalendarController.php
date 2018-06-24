<?php
/**
 * Created by PhpStorm.
 * User: pepo
 * Date: 6/23/18
 * Time: 9:57 PM
 */

namespace App\Http\Controllers;

use App\CalendarModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Calendar;
use Illuminate\Support\Facades\Auth;


class CalendarController
{
    /**
     * Връща view-то за седмица
     */
    function getWeekView()
    {
        return view('calendar.week');
    }

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
     * @param int $yearsDiff за след/преди колко години да се заредят месеци (пример: -1 = преди 1 година )
     *
     * @return view('calendar.calendar')
     */
    function getMonths(Request $request, $yearsDiff = 0)
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

        return view('calendar.calendar', ['dates' => $daysWithEvents, 'yearsDiff' => $yearsDiff]);
    }

    /*
     * Връща view за ден
     *
     */
    function getDay($day, $month, $year)
    {

        $monthNow = date('n');
        $currentDay = (int)date('d');
        $relativeMonth = $month - $monthNow;
        $numberOfDays = Calendar::getDaysMonth($relativeMonth);
        (int)$monthNow <= $month ? $year = (int)date('Y') : $year = (int)date('Y') + 1;
        $dt = Carbon::createFromDate($year, $month, $day);

        return view('calendar.day', [
            'currentDay' => $currentDay,
            'month' => $month,
            'day' => $day,
            'monthNow' => $monthNow,
            'monthInt' => $relativeMonth,
            'carbonDt' => $dt,
            'year' => $year
        ]);

    }

    /**
     * Запазва event в mongodb
     *
     * @param Request $request
     */
    function postEvent(Request $request){
        $name = $request->get('name');
        $wholeDay = $request->get('wholeDay');
        $startTime = strtotime($request->get('startDate'));
        $endTime = strtotime($request->get('endDate'));
        $notifications = $request->get('notifications');
        $type = "personal";
        dd($name);
        if($startTime < $endTime || $wholeDay == true){
            $startDate = date('d/m/Y', $startTime);
            $endDate = date('d/m/Y', $endTime);
            if($startDate === $endDate){
                dd('in');
                $calendar = new CalendarModel;
                $calendar->name = $name;
                $calendar->wholeDay = $wholeDay;
                if($wholeDay == false){
                    $calendar->startDate = $startDate;
                    $calendar->endDate = $endDate;
                }
                $calendar->type = $type;
            }
        }
    }
}