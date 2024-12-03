<?php

namespace Tltcms\Traits;

trait Ordered
{
    /**
     * @param $query
     * @return mixed
     */
    public function scopeOrderedByName($query): mixed
    {
        return $query->orderBy('sort');
    }
}
