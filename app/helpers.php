<?php
function season() {
    $SeasonDates = [
        '/12/21'=>'winter',
        '/09/21'=>'autumn',
        '/06/21'=>'summer',
        '/03/21'=>'spring',
        '/01/01'=>'winter'
    ]; //това е нужно заради 1 януари
    foreach ($SeasonDates as $key => $value)
    {
        $SeasonDate = date("Y").$key;
        if (strtotime("now") > strtotime($SeasonDate)) //Aко сме след дата на начало на сезона
        {
            return $value;
        }
    }
}