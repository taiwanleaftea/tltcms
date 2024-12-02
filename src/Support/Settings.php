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
    private array $settings = [];

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public function get(string $key, mixed $default = null): mixed
    {
        if (!$this->settings) {
            $this->load();
        }
        return $this->settings[$key] ?? $default;
    }

    /**
     * @return void
     */
    public function flush(): void
    {
        Cache::forget('settings');
        $this->settings = [];
    }

    /**
     * @return void
     */
    private function load(): void
    {
        if (Cache::has('settings')) {
            $this->settings = Cache::get('settings');
        } else {
            foreach (Setting::all() as $item) {
                $this->settings[$item->key] = match ($item->type) {
                    ValueType::Bool => (bool)$item->value,
                    ValueType::Int => (int)$item->value,
                    default => (string)$item->value,
                };
            }

            Cache::forever('settings', $this->settings);
        }
    }
}
