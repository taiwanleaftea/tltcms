<?php

return [
    /*
     * Disk for images
     */
    'disk' => 'public',

    /*
     * Convert to Webp format if supported
     */
    'convert_to_webp' => true,

    /*
     * Path to Webp image cache
     */
    'cache_webp' => 'cache/webp/',

    /*
     * No_photo image
     */
    'no_photo' => 'images/no-photo.svg',
    'no_photo_width' => 512,
    'no_photo_height' => 512,

    /*
     * Thumbnails images
     */
    'thumb_path' => 'thumbs/',
    'thumb_width' => 256,
    'thumb_height' => 256,

    /*
     * Prefix to images in filesystem
     */
    'filesystem_prefix' => 'app/public/',

    /*
     * Prefix to images from webroot
     */
    'url_prefix' => 'storage/',

    /*
     *
     */

    /*
    |--------------------------------------------------------------------------
    | Intervention Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports “GD Library” and “Imagick” to process images
    | internally. Depending on your PHP setup, you can choose one of them.
    |
    | Included options:
    |   - \Intervention\Image\Drivers\Gd\Driver::class
    |   - \Intervention\Image\Drivers\Imagick\Driver::class
    |
    */

    'driver' => \Intervention\Image\Drivers\Gd\Driver::class,

    /*
    |--------------------------------------------------------------------------
    | Intervention Image Configuration Options
    |--------------------------------------------------------------------------
    |
    | These options control the behavior of Intervention Image.
    |
    | - "autoOrientation" controls whether an imported image should be
    |    automatically rotated according to any existing Exif data.
    |
    | - "decodeAnimation" decides whether a possibly animated image is
    |    decoded as such or whether the animation is discarded.
    |
    | - "blendingColor" Defines the default blending color.
    */

    'options' => [
        'autoOrientation' => true,
        'decodeAnimation' => true,
        'blendingColor' => 'ffffff',
    ]
];
