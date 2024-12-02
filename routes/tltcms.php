<?php

declare(strict_types=1);

use Orchid\Platform\Dashboard;
use Tltcms\Orchid\Screens\SettingEditScreen;
use Tltcms\Orchid\Screens\SettingListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Settings Routes
|--------------------------------------------------------------------------
*/

Route::domain((string) config('platform.domain'))
    ->prefix(Dashboard::prefix('/'))
    ->middleware(config('platform.middleware.private'))
    ->group(function () {
        Route::screen('settings', SettingListScreen::class)
            ->name('admin.settings')
            ->breadcrumbs(fn (Trail $trail) => $trail
                ->parent('platform.index')
                ->push(__('Settings'), route('admin.settings')));

        Route::screen('settings/{setting}/edit', SettingEditScreen::class)
            ->name('admin.settings.edit')
            ->breadcrumbs(fn (Trail $trail, $setting) => $trail
                ->parent('admin.settings')
                ->push($setting->key, route('admin.settings.edit', $setting)));

        Route::screen('settings/create', SettingEditScreen::class)
            ->name('admin.settings.create')
            ->breadcrumbs(fn (Trail $trail) => $trail
                ->parent('admin.settings')
                ->push(__('Create'), route('admin.settings.create')));
    });

