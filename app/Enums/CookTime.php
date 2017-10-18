<?php

namespace App\Enums;

class CookTime extends AbstractEnum
{
    /**
     * @var integer
     */
    const TIME_LIMIT_QUICK = 30;

    /**
     * @var integer
     */
    const TIME_LIMIT_MEDIUM = 60;

    /**
     * @var integer
     */
    const TIME_LIMIT_LONG = 120;

    /**
     * @var integer
     */
    const TIME_LIMIT_LONGER = 120;


    /**
     * @var integer
     */
    const QUICK = 1;

    /**
     * @var integer
     */
    const MEDIUM = 2;

    /**
     * @var integer
     */
    const LONG = 3;

    /**
     * @var integer
     */
    const LONGER = 4;

    /**
     * @var array
     */
    protected static $labels = [
        self::QUICK => 'enums.cook_time_easy',
        self::MEDIUM => 'enums.cook_time_medium',
        self::LONG => 'enums.cook_time_long',
        self::LONGER => 'enums.cook_time_longer',
    ];
}
