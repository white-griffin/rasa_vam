<?php

namespace App\Helpers\Format;

use Hekmatinasser\Verta\Verta;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;

class Date
{
//    public static function toCarbonDateFormat($date): string
//    {
//        $date = Number::toEnglish($date);
//        return CalendarUtils::createCarbonFromFormat('Y/m/d', $date)->format('Y-m-d');
//    }
//
//    public static function toJalaliFormat($date): string
//    {
//        return verta($date)->formatJalaliDate();
//    }

    public static function toJalali($date, $format = 'Y/m/d')
    {
        if (!$date) return null;

        return Jalalian::fromCarbon($date)->format($format);
    }

    public static function toGregorian($jalaliDate, $format = 'Y/m/d')
    {
        if (!$jalaliDate) return null;

        return Jalalian::fromFormat($format, $jalaliDate)->toCarbon();
    }
}
