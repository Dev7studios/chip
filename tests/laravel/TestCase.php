<?php

namespace Tests\Laravel;

use SaaSBilling\Laravel\SaaSBillingServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SaaSBillingServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $config = require __DIR__ . '/../../src/laravel/config/saas-billing.php';

        $app['config']->set('saas-billing', $config);
    }
}