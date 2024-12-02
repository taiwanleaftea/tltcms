<?php

namespace Tltcms\Support;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Decoders\FilePathImageDecoder;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request;
use Orchid\Attachment\Models\Attachment;

class OrchidImage
{
    /**
     * @var bool
     */
    private static bool $webpSupported;

    /**
     * @var string
     */
    private static string $fsPrefix;

    /**
     * @var string
     */
    private static string $urlPrefix;

    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem|\Illuminate\Filesystem\FilesystemAdapter
     */
    private static \Illuminate\Filesystem\FilesystemAdapter|\Illuminate\Contracts\Filesystem\Filesystem $storage;

    /**
     * @var ImageManager
     */
    private static ImageManager $manager;

    public function __construct()
    {
        $driver = config('tltimage.driver');
        self::$manager = new ImageManager(new $driver());
        self::$storage = Storage::disk(config('tltimage.disk'));
        self::$webpSupported = Request::accepts('image/webp');
        self::$fsPrefix =config('tltimage.filesystem_prefix');
        self::$urlPrefix =config('tltimage.url_prefix');
    }

    /**
     * Render image meta tags
     *
     * @param int|null $id
     * @param string|null $alt
     * @return string
     */
    public function renderSocial(int|null $id, string $alt = null): string
    {
        $rendered = '';

        if ($id) {
            $model = Attachment::find($id);

            if ($model) {
                $fullname = $model->path . $model->name . '.' . $model->extension;

                if (!$model->width || !$model->height) {
                    try {
                        $image = self::$manager->read(storage_path(self::$fsPrefix . $fullname), FilePathImageDecoder::class);
                    } catch (Exception $exception) {
                        Log::error('Get image: ' . $exception->getMessage() . ' ' . $fullname);
                        return '';
                    }

                    $model->width = $image->width();
                    $model->height = $image->height();
                    $model->save();
                }

                if (!$alt) {
                    $alt = $model->alt;
                }

                $rendered = view('tltcms::modules.tltimage.social', [
                    'url' => asset(self::$urlPrefix . $fullname),
                    'alt' => $alt,
                    'width' => $model->width,
                    'height' => $model->height,
                ])->render();
            }
        }

        return $rendered;
    }

    /**
     * Render html img tag
     *
     * @param int|null $id
     * @param string $class
     * @param string|null $alt
     * @param string|null $title
     * @return string
     */
    public function renderHTML(int|null $id, string $class = '', string $alt = null, string $title = null): string
    {
        $url = config('tltimage.no_photo');
        $width = config('tltimage.no_photo_width');
        $height = config('tltimage.no_photo_height');

        $model = Attachment::find($id);

        if ($model) {
            $fullname = $model->path . $model->name . '.' . $model->extension;

            if (!$model->width || !$model->height) {
                try {
                    $image = self::$manager->read(storage_path(self::$fsPrefix . $fullname), FilePathImageDecoder::class);

                    $model->width = $image->width();
                    $model->height = $image->height();
                    $model->save();
                } catch (Exception $exception) {
                    Log::error('Get image: ' . $exception->getMessage() . ' ' . $fullname);
                }
            }

            $url = asset(self::$urlPrefix . $this->webp($fullname));
            $width = $model->width;
            $height = $model->height;
            $alt = $alt ?: $model->alt;
            $title = $title ?: $model->title;
        }

        return view('tltcms::modules.tltimage.html', [
            'url' => $url,
            'class' => $class,
            'width' => $width,
            'height' => $height,
            'alt' => $alt,
            'title' => $title,
        ])->render();
    }

    /**
     * Generate thumbnail
     *
     * @param int|null $id
     * @param int $width
     * @param int $height
     * @param bool $crop
     * @param string $nophoto
     * @return string
     */
    public function thumb(int|null $id, int $width = null, int $height = null, bool $crop = true): string
    {
        $width = $width ?? config('tltimage.thumb_width');
        $height = $height ?? config('tltimage.thumb_height');
        $cropped = $crop ? 'cropped' : 'padded';
        $thumbPath = config('tltimage.thumb_path') . $width . 'x' . $height . '-' . $cropped . '/';

        $model = $id ? Attachment::find($id) : null;

        if ($model) {
            $fullname = $model->path . $model->name . '.' . $model->extension;
            $thumb = $thumbPath . $model->path . $model->name . '.' . $model->extension;
        } else {
            $fullname = config('tltimage.no_photo');
            $thumb = $thumbPath . $fullname;

            if (Str::beforeLast($fullname, '.') == 'svg') {
                return asset(self::$urlPrefix . $fullname);
            }
        }

        if (self::$storage->exists($thumb)  && self::$storage->lastModified($fullname) <= self::$storage->lastModified($thumb)) {
            $thumb = $fullname;
        } else {
            try {
                $image = self::$manager->read(storage_path(self::$fsPrefix . $fullname), FilePathImageDecoder::class);
            } catch (Exception $exception) {
                Log::error('Get image (thumb): ' . $exception->getMessage() . ' ' . $fullname);
            }

            if (isset($image)) {
                $this->makeDirectory($thumb);

                try {
                    if ($crop) {
                        $thumbnail = ($image->cover($width, $height)->crop($width, $height))->save(self::$storage->path($thumb));
                    } else {
                        $thumbnail = ($image->pad($width, $height))->save(self::$storage->path($thumb));
                    }
                } catch (Exception $exception) {
                    Log::error('Save thumb: ' . $exception->getMessage() . ' ' . $fullname);
                }
            }
        }

        return asset(self::$urlPrefix . $this->webp($thumb));
    }

    /**
     * Render HTML for thumbnail image
     *
     * @param int|null $id
     * @param string $class
     * @param string|null $alt
     * @param string|null $title
     * @param int|null $width
     * @param int|null $height
     * @param bool $crop
     * @return string
     */
    public function thumbHTML(int|null $id, string $class = '', string $alt = null, string $title = null, int $width = null, int $height = null, bool $crop = true): string
    {
        return view('tltcms::modules.tltimage.thumb', [
            'url' => $this->thumb($id, $width, $height, $crop),
            'class' => $class,
            'width' => $width ?? config('tltimage.thumb_width'),
            'height' => $height ?? config('tltimage.thumb_height'),
            'alt' => $alt,
            'title' => $title,
        ])->render();
    }

    /**
     * Convert to Webp and store Webp in cache
     *
     * @param string $image
     * @return string
     */
    public function webp(string $image): string
    {
        if (config('tltimage.convert_to_webp') && self::$webpSupported && self::$storage->exists($image)) {
            $webp = config('tltimage.cache_webp') . Str::beforeLast($image, '.') . '.webp';
            
            if (self::$storage->exists($webp) && self::$storage->lastModified($image) <= self::$storage->lastModified($webp)) {
                $image = $webp;
            } else {
                $this->makeDirectory($webp);

                try {
                    $img = self::$manager->read(self::$storage->path($image));
                    $img = $img->encode(new WebpEncoder());
                    $img->save(self::$storage->path($webp));
                } catch (Exception $exception) {
                    Log::error('Generate WebP: ' . $exception->getMessage());
                }

                $image = isset($img) ? $webp : $image;
            }
        }

        return $image;
    }

    /**
     * Create directory if not exists
     *
     * @param string $path
     * @return void
     */
    private function makeDirectory(string $path): void
    {
        $directory = Str::beforeLast($path, '/');

        if (self::$storage->directoryMissing($directory)) {
            self::$storage->makeDirectory($directory);
        }
    }
}
