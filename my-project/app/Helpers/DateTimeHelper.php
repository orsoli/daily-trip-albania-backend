<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateTimeHelper
{
    public static function formatTime($time){
        return Carbon::parse($time)->format('H:i');
    }
}
