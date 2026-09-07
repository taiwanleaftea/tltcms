<?php

namespace Tltcms\Test;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tltcms\Support\Settings;

class SettingsTest extends FeatureTestCase
{
    public function test_settings_are_loaded_after_the_cache_is_flushed(): void
    {
        $settings = new Settings;
        $settings->flush();
        Cache::forget('settings');

        DB::table('settings')->insert([
            'key' => 'site.name',
            'value' => 'Mildai',
            'type' => 'string',
        ]);

        self::assertSame('Mildai', $settings->get('site.name'));
    }
}
