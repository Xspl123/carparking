<?php

if (!function_exists('generateOTP')) {
    function generateOTP($length = 6)
    {
        return str_pad(mt_rand(1, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    }
}

// app/Helpers/CustomHelper.php

if (!function_exists('generateRandomColor')) {
    function generateRandomColor()
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
}
