<?php

namespace Tltcms\Support\Facades;

use Tltcms\Support\MainMenu as MainMenuClass;
use Illuminate\Support\Facades\Facade;

class MainMenu extends Facade
{
    /**
     * Initiate a mock expectation on the facade.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return MainMenuClass::class;
    }
}
