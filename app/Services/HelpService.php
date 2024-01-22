<?php

namespace App\Services;

class HelpService
{

    public static function generateRandomString($length = 8)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $digits = '0123456789';
        $txt_length = round($length / 2);
        $characters = substr(str_shuffle($characters), 0, $txt_length);
        $digits = substr(str_shuffle($digits), 0, $length - $txt_length);

        $randomString = ($characters) . ($digits);

        return $randomString;
    }
}
