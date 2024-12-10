<?php

namespace Tltcms\Providers;

use Tltcms\Support\Facades\OrchidImage;
use Illuminate\Support\ServiceProvider;

class OrchidImageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(OrchidImage::class, function () {
            return new OrchidImage();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
