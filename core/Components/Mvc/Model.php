<?php

namespace Core\Components\Mvc;

use Core\Components\DB\ORM;
use Core\Components\Str;

/**
 * Class Model
 *
 * @package Justify\System
 */
class Model extends ORM
{
    /**
     * Method return encoded variable
     *
     * Returns variable safe
     * Use this method when you work with data
     *
     * @param mixed $var variable to encode
     * @return string
     */
    public static function encode($var)
    {
        return htmlspecialchars(trim($var), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Method return decoded variable
     *
     * Warning!
     * Decoded variable is unsafe
     * Don't use this method when you upload data in data base
     *
     * @param mixed $var variable to decode
     * @return string
     */
    public static function decode($var)
    {
        return htmlspecialchars_decode($var, ENT_QUOTES);
    }

    public static function getClassName()
    {
        $segments = explode('\\', static::class);

        return array_pop($segments);
    }

    /**
     * Returns table name
     *
     * @return string
     */
    public static function tableName()
    {
        return Str::camelToSnake(self::getClassName());
    }
}
