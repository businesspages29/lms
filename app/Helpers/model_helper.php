<?php

use Carbon\Carbon;

if (!function_exists('booking_type_option')) {
    function booking_type_option()
    {
        return [
            'full' => 'Full Day',
            'half' => 'Half Day',
        ];
        
    }
}

if (!function_exists('booking_slot_option')) {
    function booking_slot_option()
    {
        return [
            'morning' => 'Morning',
            'evening' => 'Evening',
        ];
        
    }
}
if (!function_exists('booking_slot_check')) {
    function booking_slot_check($time)
    {
        $startDate = Carbon::createFromFormat('H:i a', '06:00 AM');
        $endDate = Carbon::createFromFormat('H:i a', '05:59 PM');
        $timeCarbon = Carbon::parse($time);
        return $timeCarbon->between($startDate, $endDate, true);
    }
}
