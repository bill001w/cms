<?php

namespace App\Services\Core;

class Basic
{
    public static $lang;
    public static $config = array();
    public static $language = array();

    public static function get_language()
    {
        return self::$language;
    }
}