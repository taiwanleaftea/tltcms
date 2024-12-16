<?php

namespace Tltcms\Support;

use Tltcms\Enums\ValueType;
use Tltcms\Models\Setting;
use Illuminate\Support\Facades\Cache;

class Settings
{
    /**
     * @var array
     */
    static $settings;

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public function get(string $key, mixed $default = null): mixed
    {
        if (is_null(self::$settings)) {
            $this->load();
        }
        return self::$settings[$key] ?? $default;
    }

    /**
     * @return void
     */
    public function flush(): void
    {
        Cache::forget('settings');
        self::$settings = null;
    }

    /**
     * @return void
     */
    private function load(): void
    {
        if (Cache::has('settings')) {
            self::$settings = Cache::get('settings');
        } else {
            foreach (Setting::all() as $item) {
                self::$settings[$item->key] = match ($item->type) {
                    ValueType::Bool => (bool)$item->value,
                    ValueType::Int => (int)$item->value,
                    default => (string)$item->value,
                };
            }

            Cache::forever('settings', self::$settings);
        }
    }
}
