<?php

if (!function_exists('generateOTP')) {
    function generateOTP($length = 6)
    {
        return str_pad(mt_rand(1, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    }
}
