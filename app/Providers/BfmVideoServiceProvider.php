<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Components\BfmVideo;

/**
 * Class BfmVideoServiceProvider
 * @package App\Providers
 */
class BfmVideoServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('bfm.video', function () {
            return new BfmVideo();
        });

        $this->app->alias('bfm.video', 'App\Components\BfmVideo');
    }
}
