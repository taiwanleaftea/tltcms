<?php

namespace Tltcms\Test;

use Orchestra\Testbench\TestCase;

class FeatureTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    protected function getPackageProviders($app): array
    {
        return [
            'Tltcms\Providers\TltcmsServiceProvider',
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function setUpDatabase(): void
    {
        $this->artisan('migrate')->run();
    }
}
