<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Calendar extends Model
{


    const monthsBg = [1 => 'Януари', 'Февруари', 'Март', 'Април', 'Май', 'Юни', 'Юли', 'Август', 'Септември', 'Октомври', 'Ноември', 'Декември'];
    const weekDaysBg = ['Неделя', 'Понеделник', 'Вторник', 'Сряда', 'Четвъртък', 'Петък', 'Събота'];
    const weekDaysShortBg = ['Нед', 'Пон', 'Втор', 'Сряд', 'Четв', 'Пет', 'Съб'];

    const monthsEn = [1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December',];
    const weekDaysEn = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const weekDaysShortEn = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    /**
     * @param $month - относителния индекс на месеца (например 0 се сегашния 2 е месеца след 2 месец, -1 е миналия месец)
     *
     *
     * @return int
     */
    public static function getDaysMonth($month = 0)
    {
        return $daysInNextMonth = cal_days_in_month(0, date('m', strtotime("$month month")), date('Y', strtotime("$month month")));
        //брой дни в избрания месец

    }

    /**
     * @param $month - relative month index (for example  1 means the month after current month)
     *
     * @return int
     */
    public static function getFirstDayOfWeek($month = 0)
    {
        //number of free spaces to print (days in previous month)
        return $MonthFirstDayOfWeek = date('w', strtotime('1' . date('M', strtotime("$month month")) . '' . date('Y', strtotime("$month month"))));
    }

    /**
     * @return int
     */
    public static function getDaysInSecondNextMonth()
    {
        return $daysInSecondNextMonth = cal_days_in_month(0, date('m', strtotime('+2 month')), date('Y', strtotime('+2 month')));

    }

    /**
     * @return array
     */
    public static function getWeekDays()
    {
        $wd = self::weekDaysEn;
        if (App::getLocale() == "bg") {
            $wd = self::weekDaysBg;
        }
        return $wd;
    }

    public static function getWeekDaysShorts()
    {
        $wds = self::weekDaysShortEn;
        if (App::getLocale() == "bg") {
            $wds = self::weekDaysShortBg;
        }
        return $wds;
    }

    public static function getMonthsNumber()
    {
        $m = self::monthsEn;
        if (App::getLocale() == "bg") {
            $m = self::monthsBg;
        }
        return $m;
    }

    /**
     * getRestDays
     *
     * Зарежда настройките за почивни дни на оптика с id=$opticansId
     * Използва се от клиенти и служители
     *
     * @param int $opticansId
     *
     * @return array
     */
    public static function getRestDays($opticansId = null)
    {
        if ($opticansId === null) {
            $opticansId = Auth::user()->opticans;
        }

        $data = DB::table('opticans')->select('examinationSettings')->where('id', $opticansId)->first();

        $examinationSettings = unserialize($data->examinationSettings);

        return ['restDays' => $examinationSettings['restDays']];
    }

    /**
     * getHolidays
     *
     * Зарежда настройките за празниците на оптика с id=$opticansId
     * Използва се от клиенти и служители
     *
     * @param int $opticansId
     *
     * @return array
     */
    public static function getHolidays($opticansId = null)
    {
        if ($opticansId === null) {
            $opticansId = Auth::user()->opticans;
        }

        $data = DB::table('opticans')->select('examinationSettings')->where('id', $opticansId)->first();

        $examinationSettings = unserialize($data->examinationSettings);

        return ['holidays' => $examinationSettings['holidays']];
    }

    /**
     * getDate
     *
     * Оформя стринг от дата=$day и месец=$month
     *
     * @param int $day
     * @param inr $month
     *
     * @return string
     */
    public static function getDate($day, $month)
    {
        if ($day < 10) {
            if ($month < 10) {
                $dayMonth = "0" . $day . "-0" . $month . "";
            } else {
                $dayMonth = "0" . $day . "-" . $month . "";
            }
        } else {
            if ($month < 10) {
                $dayMonth = "" . $day . "-0" . $month . "";
            } else {
                $dayMonth = "" . $day . "-" . $month . "";
            }
        }

        return $dayMonth;
    }

    public static function holidaysArray()
    {
        return ['01-01', '03-03', '01-05', '06-05', '24-05', '06-09', '22-09', '01-11', '24-12', '25-12', '26-12'];
    }

    /**
     * orthodox_easter
     *
     * Изчислява датата на православния Великден за година=$year
     *
     * @param int $year
     *
     * @return string
     */
    public static function orthodox_easter($year)
    {
        $a = $year % 4;
        $b = $year % 7;
        $c = $year % 19;
        $d = (19 * $c + 15) % 30;
        $e = (2 * $a + 4 * $b - $d + 34) % 7;
        $month = floor(($d + $e + 114) / 31);
        $day = (($d + $e + 114) % 31) + 1;

        $stamp = mktime(0, 0, 0, $month, $day + 13, $year);

        return $stamp;
    }

    /**
     * findNumber
     *
     * връща номера на месец на база на час от името
     *
     * @param $name
     * @return int index
     */
    public static function findIndex($name)
    {
        $a = collect(self::getMonths())->filter(function ($item, $key) use ($name) {
            return preg_match('/^.*' . mb_strtolower($name) . '.*$/', mb_strtolower($item));
        })->toArray();
        $a = array_values($a);
        if (count($a)) {
            return $index = array_search(mb_strtolower($a[0]),array_map('mb_strtolower', self::getMonths()));
        }
        return '';

    }

    /** getMonths
     *
     * Гетър за месеците  където при въведен $mont=13
     * ще върне първи месец, при $month=15 - трети и тн
     *
     * @param int $month
     * @return array
     */
    public static function getMonths($month = null)
    {
        $months = self::monthsEn;
        if (App::getLocale() == "bg") {
            $months = self::monthsBg;
        }
        if ($month === null) return $months; //ако не е зададен индекс
        if (($month - (int)floor($month / 12) * 12) == 0)
            return $months[($month - (int)floor($month / 12) * 12) + 12];

        else  return $months[($month - (int)floor($month / 12) * 12)];
    }

    /** getDaysOfWeek
     *
     * Гетър за дните от седмицата
     *
     * @param string $day
     * @param string $month
     * @param string $year
     * @param string $forOrBack
     * @return array
     */
    public static function getDaysOfWeek($day, $month, $year, $forOrBack){
        $carbonDate = Carbon::createFromDate($year, $month, $day);
        $day_of_week = date('N',mktime('0','0','0', $month, $day, $year));
        if($forOrBack === "forwards"){
            $newCarbonDate = $carbonDate->addDay(8 - (int)$day_of_week);
        } else if($forOrBack === "backwards"){
            $newCarbonDate = $carbonDate->subDay((int)$day_of_week);
        } else {
            $newCarbonDate = $carbonDate;
        }

        $newDay = $newCarbonDate->day;
        $newMonth = $newCarbonDate->month;
        $newYear = $newCarbonDate->year;

        $date = "" . $newDay . "-" . $newMonth . "-" . $newYear . "";
        list($day, $month, $year) = explode("-", $date);

        $wkday = date('l',mktime('0','0','0', $month, $day, $year));

        switch($wkday) {
            case 'Monday': $numDaysToMon = 0; break;
            case 'Tuesday': $numDaysToMon = 1; break;
            case 'Wednesday': $numDaysToMon = 2; break;
            case 'Thursday': $numDaysToMon = 3; break;
            case 'Friday': $numDaysToMon = 4; break;
            case 'Saturday': $numDaysToMon = 5; break;
            case 'Sunday': $numDaysToMon = 6; break;
        }

        $monday = mktime('0','0','0', $month, $day-$numDaysToMon, $year);

        $seconds_in_a_day = 86400;

        // Get date for 7 days from Monday (inclusive)
        for($i=0; $i<7; $i++)
        {
            $dates[$i] = date('Y-m-d',$monday+($seconds_in_a_day*$i));
        }

        return $dates;
    }
}