<?php

declare(strict_types=1);

namespace Taiwanleaftea\Tltcms\Providers;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;
use Tltcms\Providers\BreadcrumbServiceProvider;
use Tltcms\Providers\MainMenuServiceProvider;
use Tltcms\Providers\OrchidImageServiceProvider;
use Tltcms\Providers\SettingsServiceProvider;
use Tltcms\Providers\SlugServiceProvider;

/**
 * Class TltcmsServiceProvider.
 */
class TltcmsServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        AboutCommand::add('TLT CMS', fn () => ['Version' => tltcms_version()]);

        $this->publishes([
            __DIR__.'/../../config/tltcms.php' => config_path('tltcms.php'),
            __DIR__.'/../../resources/images' => public_path('images'),
        ], 'tltcms');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/tltcms'),
        ], 'tltcms-views');

        $this->publishes([
            __DIR__.'/../../config/tltimage.php' => config_path('tltimage.php'),
        ], 'tltimage');

        $this->publishesMigrations([
            __DIR__.'/../../database/migrations/' => database_path('migrations')
        ], 'tltcms');

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'tltcms');

        $this->loadRoutesFrom(__DIR__.'/../../routes/tltcms.php');

        $this->loadJsonTranslationsFrom(__DIR__.'/../../lang');
    }

    /**
     * Register provider.
     *
     * @return $this
     */
    public function registerProviders(): self
    {
        foreach ($this->providers() as $provider) {
            $this->app->register($provider);
        }

        return $this;
    }

    /**
     * Get the service providers.
     */
    public function providers(): array
    {
        return [
            BreadcrumbServiceProvider::class,
            MainMenuServiceProvider::class,
            OrchidImageServiceProvider::class,
            SettingsServiceProvider::class,
            SlugServiceProvider::class,
        ];
    }

    /**
     * Register bindings the service provider.
     */
    public function register(): void
    {
        TD::macro('bool', function () {

            $column = $this->column;

            $this->render(function ($datum) use ($column) {
                return view('tltcms::admin.cells.bool',[
                    'bool' => $datum->$column
                ]);
            });

            return $this;
        });

        Sight::macro('bool', function () {

            $column = $this->column;

            $this->render(function ($datum) use ($column) {
                return view('tltcms::admin.cells.bool',[
                    'bool' => $datum->$column
                ]);
            });

            return $this;
        });

        $this->registerProviders();

        $this->mergeConfigFrom(__DIR__.'/../../config/tltcms.php', 'tltcms');
        $this->mergeConfigFrom(__DIR__.'/../../config/tltimage.php', 'tltimage');
    }
}
