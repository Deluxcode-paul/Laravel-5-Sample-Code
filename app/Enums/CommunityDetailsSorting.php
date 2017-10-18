<?php

namespace App\Enums;

/**
 * Class CommunityDetailsSorting
 * @package App\Enums
 */
class CommunityDetailsSorting extends AbstractEnum
{
    /**
     * @var string
     */
    const RECENT   = 'recent';
    const VOTES = 'votes';

    /**
     * @var array
     */
    protected static $labels = [
        self::RECENT   => 'enums.sorting.community.recent',
        self::VOTES => 'enums.sorting.community.votes'
    ];
}
