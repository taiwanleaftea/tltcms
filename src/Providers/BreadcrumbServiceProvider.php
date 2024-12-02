<?php

namespace Tltcms\Providers;

use Tltcms\Support\Facades\Breadcrumb;
use Illuminate\Support\ServiceProvider;

class BreadcrumbServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Breadcrumb::class, function () {
            return new Breadcrumb();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
