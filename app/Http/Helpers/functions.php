<?php

if (!function_exists('time_since')) {
    function time_since($timestamp)
    {
        $last_date = date('y-m-d H:i:s', $timestamp);
        $current_date = date('y-m-d H:i:s');

        $date_diff = strtotime($current_date) - strtotime($last_date);
        $months_diff = floor($date_diff / (60*60*24*30));
        $days_diff = floor($date_diff / (60*60*24));
        $hours_diff = floor($date_diff / (60*60));
        $minutes_diff = floor($date_diff / (60));

        if ($minutes_diff < 60) {
            return $minutes_diff.' minutes';
        } elseif ($hours_diff != 0 && $hours_diff<24) {
            return $hours_diff.' hours';
        } elseif ($hours_diff>=24 || $days_diff>0) {
            return $days_diff.' days';
        } elseif ($days_diff > 31) {
            return $months_diff.' months';
        }

        return '';
    }
}
