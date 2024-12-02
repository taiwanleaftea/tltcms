<?php

namespace Tltcms\Providers;

use Tltcms\Support\Facades\Slug;
use Illuminate\Support\ServiceProvider;

class SlugServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Slug::class, function () {
            return new Slug();
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
