<?php

/*
if (!function_exists('log_error')) {
    function log_error($exception, $dump = true)
    {
        if (config('app.env') == 'local' && $dump) {
            dd($exception);
        }
        Log::error($exception);
    }
}
*/

use App\Models\LeaveMaster;

if (!function_exists('leave_option')) {
    function leave_option()
    {
        return LeaveMaster::PluckNameAndId()->all();
    }
}
