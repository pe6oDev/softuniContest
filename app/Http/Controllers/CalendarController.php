<?php
/**
 * Created by PhpStorm.
 * User: pepo
 * Date: 6/23/18
 * Time: 9:57 PM
 */

namespace App\Http\Controllers;


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
}