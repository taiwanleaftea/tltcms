<?php

namespace Tltcms\Traits;

trait Ordered
{
    /**
     * @param $query
     * @return mixed
     */
    public function scopeOrdered($query): mixed
    {
        return $query->orderBy('sort');
    }
}
