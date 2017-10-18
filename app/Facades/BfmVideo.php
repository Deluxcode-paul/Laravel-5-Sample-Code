<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class BfmVideo
 * @package App\Facades
 */
class BfmVideo extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bfm.video';
    }
}
