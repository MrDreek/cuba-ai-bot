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
            $needYearCheek = false;
            $date = self::yearCheck($date, $needYearCheek);

            $d = Carbon::parse($date) ?? false;

            if ($d && $needYearCheek && $d->lt(Carbon::now())) {
                $d->addYear();
            }
        } catch (\Exception $e) {
            $month = explode(' ', $date)[1] ?? null;

            if ($month === null) {
                return false;
            }

            $returned = \str_replace(\array_keys(self::MONTH_LIST), \array_values(self::MONTH_LIST), $date);

            if ($returned === $date) {
                $returned = \str_replace(' ', '.', $date);
            }

            try {
                $d = Carbon::parse($returned) ?? false;
                if ($needYearCheek && $d->lt(Carbon::now())) {
                    $d->addYear();
                }
            } catch (\Exception $e) {
                return false;
            }

            return $d->format('d.m.Y');
        }

        return $d->format('d.m.Y');
    }

    private static function yearCheck($date, &$needYearCheek): string
    {
        $explode = \preg_split("/(\s|\.|\/)/", $date) ?? null;

        $year = [];

        if (isset($explode[0])) {
            $year[] = $explode[0];
        }

        if (isset($explode[1])) {
            $year[] = $explode[1];
        }

        if (!isset($explode[2])) {
            $needYearCheek = true;
            $year[] = date('Y');
        } else {
            $year[] = $explode[2];
        }

        return \implode(' ', $year);
    }

    private static function check($date)
    {
        $explode = \preg_split("/(\s|\.|\/)/", $date) ?? null;

        if (!isset($explode[2])) {
            return true;
        }

        return false;
    }
}
