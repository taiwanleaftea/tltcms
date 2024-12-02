<?php

namespace Tltcms\Support\Facades;

use Tltcms\Support\Slug as SlugHelper;
use Illuminate\Support\Facades\Facade;

class Slug extends Facade
{
    /**
     * Initiate a mock expectation on the facade.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return SlugHelper::class;
    }
}
