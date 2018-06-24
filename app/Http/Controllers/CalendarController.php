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
        $dates = [];
        $daysWithEvents = [];

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

        $wholeDayEvents=CalendarModel
            ::where('wholeDay', true)
            ->where(function ($query) {
                $query ->where('user_id', Auth::user()->id)
                    ->orWhere('visibility', '=', 'public');
            })->get();

        foreach ($wholeDayEvents as &$event) {
            if (! date('d/m/Y', $event->event['startDate']) == $day.'/'.$month.'/'.$year  ) {
               unset($event);
            }
        }


//        dump(Carbon::tomorrow()->timestamp);
//        dd(Carbon::yesterday()->timestamp);

        return view('calendar.day', [
            'currentDay' => $currentDay,
            'month' => $month,
            'day' => $day,
            'monthNow' => $monthNow,
            'monthInt' => $relativeMonth,
            'carbonDt' => $dt,
            'year' => $year,
            'wholeDayEvents' => $wholeDayEvents
        ]);

    }

    /**
     * Запазва event в mongodb
     *
     * @param Request $request
     */
    function postEvent(Request $request)
    {
        $name = $request->get('name');
        $wholeDay = $request->get('wholeDay');
        $startTime = strtotime($request->get('startDate'));
        $endTime = strtotime($request->get('endDate'));
        $notifications = $request->get('notifications');
        $visibility = $request->get('visibility');
        if ($startTime < $endTime || $wholeDay == true) {
            $startDate = date('d/m/Y', $startTime);
            $endDate = date('d/m/Y', $endTime);
            if ($startDate == $endDate) {
                $calendar = new CalendarModel;
                $calendar->name = $name;
                $calendar->wholeDay = $wholeDay;
                if ($wholeDay == false) {
                    $calendar->startDate = $startTime;
                    $calendar->endDate = $endTime;
                } else {
                    $calendar->startDate = $startTime;
                }
                if ($visibility === "personal") {
                    $calendar->user_id = Auth::user()->id;
                }
                $calendar->visibility = $visibility;
                $calendar->save();
            }
        }
    }

    /**
     * Зарежда събитя в страницата за ден
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     */
    function getEvents(Request $request)
    {
        $date = $request->get('date');
        $user_id = Auth::user()->id;

        $events = CalendarModel::where('deleted_at', null)->get();
        $dayEvents = [];

        foreach ($events->all() as $event) {
            if (date('j/n/Y', $event['startDate']) === $date && date('j/n/Y', $event['endDate']) === $date && $event['user_id'] == $user_id) {
                $e = $event;
                $e['id'] = $event->_id;
                $e['startHour'] = date('G', $e['startDate']);
                $e['startMinutes'] = (int)date('i', $e['startDate']);
                $e['endHour'] = date('G', $e['endDate']);
                $e['endMinutes'] = (int)date('i', $e['endDate']);
                array_push($dayEvents, $e);
                //Mail::to('pepotov@gmail.com')->send(new newEvent($e));
            }
        }

        return response()->json(['events' => $dayEvents], 200);
    }


    /**
     * Зарежда почивни дни от mongodb
     *
     */
    function getRestDays()
    {
        $restDays = CalendarModel::where('type', 'restDay')->get();
        foreach ($restDays as $day) {
            $day->normalDate = date('d/m/Y', $day->startDate);
        }

        return response()->json(['restDays' => $restDays], 200);
    }

    /**
     * Запазва почивни дни в mongodb
     *
     * @param Request $request
     */
    function postRestDay(Request $request)
    {
        $restDay = strtotime($request->get('restDay'));

        $calendar = new CalendarModel;
        $calendar->name = "Почивен ден";
        $calendar->wholeDay = true;
        $calendar->startDate = $restDay;
        $calendar->visibility = "public";
        $calendar->type = "restDay";
        $calendar->save();
        $calendar->normalDate = date('d/m/Y', $restDay);

        return response()->json(['newRest' => $calendar], 200);
    }

    /**
     * Изтрива почивен ден от mongodb
     *
     * @param Request $request
     */
    function deleteRestDay(Request $request)
    {
        $id = $request->get('id');

        CalendarModel::where('_id', $id)->forceDelete();

        return response()->json([], 200);
    }

    /**
     * Зарежда имени дни от mongodb
     *
     */
    function getNameDays()
    {
        $nameDays = CalendarModel::where('type', 'nameDay')->get();

        foreach ($nameDays as $day) {
            $day->normalDate = date('d/m/Y', $day->startDate);
        }

        return response()->json(['nameDays' => $nameDays], 200);
    }

    /**
     * Запазва имен ден в mongodb
     *
     * @param Request $request
     */
    function postNameDay(Request $request)
    {
        $nameDay = strtotime($request->get('date'));
        $name = $request->get('name');
        $text = $request->get('description');

        $calendar = new CalendarModel;
        $calendar->name = $name;
        $calendar->text = $text;
        $calendar->wholeDay = true;
        $calendar->startDate = $nameDay;
        $calendar->visibility = "public";
        $calendar->type = "nameDay";
        $calendar->save();
        $calendar->normalDate = date('d/m/Y', $nameDay);

        return response()->json(['newName' => $calendar], 200);
    }

    /**
     * Изтрива имен ден от mongodb
     *
     * @param Request $request
     */
    function deleteNameDay(Request $request)
    {
        $id = $request->get('id');

        CalendarModel::where('_id', $id)->forceDelete();

        return response()->json([], 200);
    }
}