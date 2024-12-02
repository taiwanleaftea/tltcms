<?php

namespace Tltcms\Support\Facades;

use Tltcms\Support\Breadcrumb as BreadcrumbHelper;
use Illuminate\Support\Facades\Facade;

class Breadcrumb extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return BreadcrumbHelper::class;
    }
}
