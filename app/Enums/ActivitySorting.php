<?php

namespace App\Enums;

class ActivitySorting extends AbstractEnum
{
    /**
     * @var string
     */
    const RECENT = 'recent';
    const VIEWS  = 'views';


    protected static $labels = [
        self::RECENT => 'enums.sorting.activity.recent',
        self::VIEWS  => 'enums.sorting.activity.views',
    ];
}
