<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class BfmImage
 * @package App\Facades
 */
class BfmImage extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bfm.image';
    }
}
