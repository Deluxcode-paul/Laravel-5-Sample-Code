<?php

namespace App\Enums;

class VideoSorting extends AbstractEnum
{
    /**
     * @var string
     */
    const RECENT = 'recent';
    const OLDEST = 'oldest';


    protected static $labels = [
        self::RECENT => 'enums.sorting.videos.recent',
        self::OLDEST => 'enums.sorting.videos.oldest',
    ];
}
