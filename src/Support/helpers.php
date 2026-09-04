<?php

use Tltcms\Support\Facades\Breadcrumb;
use Tltcms\Support\Facades\MainMenu;
use Tltcms\Support\Facades\OrchidImage;
use Tltcms\Support\Facades\Settings;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

const TLTCMS_VERSION = '0.7.5';

if (! function_exists('tltcms_version')) {
    /**
     * @return string
     */
    function tltcms_version(): string {
        return TLTCMS_VERSION;
    }
}

if (! function_exists('settings')) {
    /**
     * @param $key
     * @param $default
     * @return mixed
     */
    function settings($key, $default = null): mixed
    {
        return Settings::get($key, $default);
    }
} else {
    throw new Exception('Function settings already exists.');
}

if (! function_exists('main_menu')) {
    /**
     * @return string
     */
    function main_menu(): string
    {
        return MainMenu::render();
    }
} else {
    throw new Exception('Function main_menu already exists.');
}

if (! function_exists('breadcrumb_html')) {
    /**
     * @return string
     */
    function breadcrumb_html(): string
    {
        return Breadcrumb::render();
    }
} else {
    throw new Exception('Function breadcrumb_html already exists.');
}

if (! function_exists('breadcrumb_json')) {
    /**
     * @return string
     */
    function breadcrumb_json(): string
    {
        return Breadcrumb::renderJson();
    }
} else {
    throw new Exception('Function breadcrumb_json already exists.');
}

if (! function_exists('is_crawler')) {
    /**
     * @return bool
     */
    function is_crawler(): bool
    {
        $CrawlerDetect = new CrawlerDetect;

        return $CrawlerDetect->isCrawler();
    }
} else {
    throw new Exception('Function is_crawler already exists.');
}

if (! function_exists('image_social')) {
    /**
     * @param int|null $id
     * @param string|null $alt
     * @return string
     */
    function image_social(int|null $id, ?string $alt = null): string
    {
        return OrchidImage::renderSocial($id, $alt);
    }
} else {
    throw new Exception('Function image_social already exists.');
}

if (! function_exists('image_html')) {
    /**
     * @param int|null $id
     * @param string $class
     * @param string|null $alt
     * @param string|null $title
     * @return string
     */
    function image_html(int|null $id, string $class = '', ?string $alt = null, ?string $title = null): string
    {
        return OrchidImage::renderHTML($id, $class, $alt, $title);
    }
} else {
    throw new Exception('Function image_html already exists.');
}

if (! function_exists('thumb_html')) {
    /**
     * @param int|null $id
     * @param string $class
     * @param string|null $alt
     * @param string|null $title
     * @param int|null $width
     * @param int|null $height
     * @param bool $crop
     * @return string
     */
    function thumb_html(int|null $id, string $class = '', ?string $alt = null, ?string $title = null, ?int $width = null, ?int $height = null, bool $crop = true): string
    {
        return OrchidImage::thumbHTML($id, $class, $alt, $title, $width, $height, $crop);
    }
} else {
    throw new Exception('Function thumb_html already exists.');
}

if (! function_exists('sanitize_content_html')) {
    /**
     * @param string|null $html
     * @return string
     */
    function sanitize_content_html(?string $html): string
    {
        if ($html === null || $html === '') {
            return '';
        }

        $html = preg_replace('/\sdata-[a-zA-Z0-9_-]+="[^"]*"/', '', $html);
        $html = preg_replace('/\sclass="PDq2pG_[^"]*"/', '', $html);
        $html = preg_replace('/<p[^>]*>(?:\s|&nbsp;|<br\s*\/?>)*<\/p>/i', '', $html);

        return trim($html);
    }
} else {
    throw new Exception('Function sanitize_content_html already exists.');
}
