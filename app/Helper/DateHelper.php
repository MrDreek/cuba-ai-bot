<?php
/**
 * Created by PhpStorm.
 * User: mr_dreek
 * Date: 08.12.18
 * Time: 22:27
 */

namespace App\Helper;


use Illuminate\Support\Carbon;

class DateHelper
{
    private const MONTH_LIST = [
        'января' => 'january',
        'февраля' => 'february',
        'марта' => 'march',
        'апреля' => 'april',
        'мая' => 'may',
        'июня' => 'june',
        'июля' => 'jule',
        'августа' => 'august',
        'сентября' => 'september',
        'октября' => 'october',
        'ноября' => 'november',
        'декабря' => 'december',
    ];

    public static function parseDate($date)
    {
        $date = \trim($date);
        try {
            $d = Carbon::parse($date)->format('d.m.Y') ?? false;
        } catch (\Exception $e) {
            $date = self::yearCheck($date);
            $month = explode(' ', $date)[1] ?? null;

            if ($month === null) {
                return false;
            }

            $returned = \str_replace(\array_keys(self::MONTH_LIST), \array_values(self::MONTH_LIST), $date);

            if ($returned === $date) {
                return false;
            }

            try {
                $d = Carbon::parse($returned)->format('d.m.Y') ?? false;
            } catch (\Exception $e) {
                return false;
            }

            return $d;
        }

        return $d;
    }

    private static function yearCheck($date)
    {
        $explode = \explode(' ', $date) ?? null;
        if (isset($explode[3])) {
            unset($explode[3]);
        }

        return \implode(' ', $explode);
    }
}
