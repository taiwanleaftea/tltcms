<?php

namespace Tltcms\Support\Facades;

use Tltcms\Support\Settings as SettingsHelper;
use Illuminate\Support\Facades\Facade;

class Settings extends Facade
{
    /**
     * Initiate a mock expectation on the facade.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return SettingsHelper::class;
    }
}
