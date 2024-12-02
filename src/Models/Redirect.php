<?php

namespace Tltcms\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Screen\AsSource;

class Redirect extends Model
{
    use AsSource, Filterable;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected array $allowedFilters = [
        'from' => Like::class,
        'to' => Like::class,
        'model' => Like::class,
        ];

    /**
     * @var array
     */
    protected array $allowedSorts = ['from', 'to', 'model'];
}
