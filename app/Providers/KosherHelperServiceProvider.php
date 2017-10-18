<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Components\KosherHelper;

/**
 * Class KosherHelperServiceProvider
 * @package App\Providers
 */
class KosherHelperServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('kosher.helper', function () {
            return new KosherHelper();
        });

        $this->app->alias('kosher.helper', 'App\Components\KosherHelper');
    }
}
