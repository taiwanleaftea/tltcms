<?php

namespace Tltcms\Traits;

trait OrderedByName
{
    /**
     * @param $query
     * @return mixed
     */
    public function scopeOrderedByName($query): mixed
    {
        return $query->orderBy('name');
    }
}
