<?php

namespace Tltcms\Test;

use Illuminate\Support\Facades\DB;
use Orchid\Attachment\Models\Attachment;
use Tltcms\Support\OrchidImage;

class OrchidImageTest extends FeatureTestCase
{
    public function test_render_html_skips_the_database_for_a_missing_attachment_id(): void
    {
        DB::flushQueryLog();
        DB::enableQueryLog();

        $html = $this->app->make(OrchidImage::class)->renderHTML(null);

        self::assertSame([], DB::getQueryLog());
        self::assertStringContainsString('images/no-photo.svg', $html);
    }

    public function test_render_attachment_html_uses_the_loaded_attachment_without_a_query(): void
    {
        $attachment = new Attachment([
            'path' => 'images/',
            'name' => 'example',
            'extension' => 'jpg',
        ]);
        $attachment->width = 640;
        $attachment->height = 480;

        DB::flushQueryLog();
        DB::enableQueryLog();

        $html = $this->app->make(OrchidImage::class)->renderAttachmentHTML($attachment, 'card-image');

        self::assertSame([], DB::getQueryLog());
        self::assertStringContainsString('card-image', $html);
        self::assertStringContainsString('images/example.jpg', $html);
    }

    public function test_render_html_keeps_the_id_based_api_working(): void
    {
        $attachment = new Attachment([
            'path' => 'images/',
            'name' => 'legacy',
            'extension' => 'jpg',
        ]);
        $attachment->width = 640;
        $attachment->height = 480;
        $attachment->save();

        DB::flushQueryLog();
        DB::enableQueryLog();

        $html = $this->app->make(OrchidImage::class)->renderHTML($attachment->id);

        self::assertCount(1, DB::getQueryLog());
        self::assertStringContainsString('images/legacy.jpg', $html);
    }
}
