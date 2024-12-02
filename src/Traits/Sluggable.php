<?php

namespace Tltcms\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait Sluggable
{
    /**
     * @param $query
     * @param $slug
     * @return mixed
     */
    public function scopeSearchSlug($query, $slug): mixed
    {
        return $query->where('slug', '=', strtolower($slug));
    }

    /**
     * Convert slug to lower case.
     */
    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn (string|null $value) => strtolower($value),
        );
    }
}
