<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalendarModel extends Eloquent
{
    /*
     |--------------------------------------
     | Calendar Model
     |-------------------------------------
     | Модел за събитията
     | работи с mongo db
     |
     */


    use SoftDeletes;

    protected $collection = 'events';
    protected $connection = 'mongodb';
    protected $dates = ['deleted_at'];

}
