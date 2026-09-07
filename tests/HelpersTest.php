<?php

namespace Tltcms\Test;

use Tltcms\Test\FeatureTestCase;

class HelpersTest extends FeatureTestCase
{
    public function test_it_returns_the_package_version(): void
    {
        self::assertNotEmpty(tltcms_version());
    }
}
