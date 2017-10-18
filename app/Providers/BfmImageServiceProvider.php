<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Components\BfmImage;

/**
 * Class BfmImageServiceProvider
 * @package App\Providers
 */
class BfmImageServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('bfm.image', function () {
            return new BfmImage();
        });

        $this->app->alias('bfm.image', 'App\Components\BfmImage');
    }
}
