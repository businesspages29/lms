<?php

use Carbon\Carbon;

if (!function_exists('date_range_count')) {
    function date_range_count($from, $to)
    {
        $date = Carbon::parse($from);
        $now = Carbon::parse($to);
        
        return $date->diffInDays($now);       

    }
}
