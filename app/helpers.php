<?php

if (!function_exists('format_currency')) {
    function format_currency($value)
    {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }
}

if (!function_exists('str_limit')) {
    function str_limit($value, $limit = 100, $end = '...')
    {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }
        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')) . $end;
    }
}
