<?php

namespace App\Enums;

class CommunitySearchSorting extends AbstractEnum
{
    /**
     * @var string
     */
    const RECENT   = 'recent';
    const ACTIVITY = 'activity';

    /**
     * @var array
     */
    protected static $labels = [
        self::RECENT   => 'enums.sorting.community.recent',
        self::ACTIVITY => 'enums.sorting.community.activity'
    ];
}
