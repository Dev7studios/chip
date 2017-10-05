<?php

namespace Tests\Laravel;

use Dev7studios\Chip\Laravel\ChipServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ChipServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $config = require __DIR__ . '/../../src/laravel/config/chip.php';

        $app['config']->set('chip', $config);
    }
}