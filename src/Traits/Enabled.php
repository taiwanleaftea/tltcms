<?php

namespace Tltcms\Traits;

trait Enabled
{
    public function scopeEnabled($query)
    {
        return $query->where('status', '=', 1);
    }
}
