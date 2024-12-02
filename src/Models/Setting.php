<?php

namespace Tltcms\Models;

use Tltcms\Enums\ValueType;
use Tltcms\Support\Facades\Settings;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Screen\AsSource;

class Setting extends Model
{
    use AsSource, Filterable;

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
        'key' => Like::class,
        'value' => Like::class,
    ];

    /**
     * @var array
     */
    protected array $allowedSorts = ['key', 'value'];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        parent::booted();

        static::created(function (Setting $setting) {
            Settings::flush();
        });

        static::updated(function (Setting $setting) {
            Settings::flush();
        });

        static::deleted(function (Setting $setting) {
            Settings::flush();
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => ValueType::class,
        ];
    }

    /**
     * Convert key to lower case.
     */
    protected function key(): Attribute
    {
        return Attribute::make(
            set: fn (string|null $value) => strtolower(Str::trim($value)),
        );
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOrdered($query): mixed
    {
        return $query->orderBy('key');
    }
}
