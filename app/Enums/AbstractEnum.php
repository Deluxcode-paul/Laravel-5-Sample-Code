<?php

namespace App\Enums;

/**
 * Class AbstractEnum
 * @package App\Enums
 */
class AbstractEnum
{
    /**
     * @var array
     */
    protected static $labels = [];

    /**
     * @param mixed $value
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public static function label($value)
    {
        return isset(static::$labels[$value]) ? trans(static::$labels[$value]) : '';
    }

    /**
     * @return array
     */
    public static function labels()
    {
        return array_map(function ($label) {
            return trans($label);
        }, static::$labels);
    }

    /**
     * @return array
     */
    public static function values()
    {
        return array_keys(static::$labels);
    }
}
