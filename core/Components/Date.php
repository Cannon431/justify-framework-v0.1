<?php

namespace Core\Components;

/**
 * Class Date
 *
 * Methods for working with date
 *
 * @package Justify\Components
 */
class Date
{
    /**
     * Method converts month number to russian string in genitive case
     *
     * @param integer $month month number
     * @return string|bool
     */
    public static function russianMonthInGC($month)
    {
        $months = [
            'января', 'февраля', 'марта',
            'апреля', 'мая', 'июня',
            'июля', 'августа', 'сентября',
            'октября', 'ноября', 'декабря'
        ];

        return $months[$month - 1] ?? false;
    }

    /**
     * Checks year for leap
     * 
     * If year leap then returns true else returns false
     * 
     * @since 2.1.0
     * @param int $year checks year
     * @return bool
     */
    public static function isLeapYear($year)
    {
        return ($year % 4 == 0) && (($year % 100 != 0) || ($year % 400 == 0));
    }
}
