<?php

namespace Tltcms\Support\Facades;

use Tltcms\Support\OrchidImage as OrchidImageHelper;
use Illuminate\Support\Facades\Facade;

class OrchidImage extends Facade
{
    /**
     * Initiate a mock expectation on the facade.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return OrchidImageHelper::class;
    }
}
