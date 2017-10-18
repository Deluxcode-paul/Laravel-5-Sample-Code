<?php

namespace App\Enums;

class CommunityReplySorting extends AbstractEnum
{
    /**
     * @var string
     */
    const RECENT = 'recent';
    const VOTES  = 'votes';


    protected static $labels = [
        self::RECENT => 'enums.sorting.community.recent',
        self::VOTES  => 'enums.sorting.community.votes',
    ];
}
