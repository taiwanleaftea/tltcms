<?php

use Tltcms\Support\Facades\Breadcrumb;
use Tltcms\Support\Facades\MainMenu;
use Tltcms\Support\Facades\Settings;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

const VERSION = '0.2.1';

if (! function_exists('settings')) {
    function settings($key, $default = null) {
        return Settings::get($key, $default);
    }
}

if (! function_exists('main_menu')) {
    function main_menu() {
        return MainMenu::render();
    }
}

if (! function_exists('breadcrumb_html')) {
    function breadcrumb_html() {
        return Breadcrumb::render();
    }
}

if (! function_exists('breadcrumb_json')) {
    function breadcrumb_json() {
        return Breadcrumb::renderJson();
    }
}

if (! function_exists('is_crawler')) {
    function is_crawler() {
        $CrawlerDetect = new CrawlerDetect;

        return $CrawlerDetect->isCrawler();
    }
}

if (! function_exists('tltcms_version')) {
    function tltcms_version() {
        return VERSION;
    }
}
