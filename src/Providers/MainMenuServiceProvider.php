<?php

namespace Tltcms\Providers;

use Tltcms\Support\Facades\MainMenu;
use Illuminate\Support\ServiceProvider;

class MainMenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(MainMenu::class, function () {
            return new MainMenu();
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
