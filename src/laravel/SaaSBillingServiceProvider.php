<?php

namespace SaaSBilling\Laravel;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SaaSBillingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->defineRoutes();

        $this->publishConfig();

        $this->publishAssets();
    }

    /**
     * Define the Spark routes.
     *
     * @return void
     */
    protected function defineRoutes()
    {
        // If the routes have not been cached, we will include them in a route group
        // so that all of the routes will be conveniently registered to the given
        // controller namespace. After that we will load the Spark routes file.
        if (!$this->app->routesAreCached()) {
            Route::group([
                'namespace' => 'SaaSBilling\Laravel\Http\Controllers',
            ], function ($router) {
                require __DIR__ . '/Http/routes.php';
            });
        }
    }

    protected function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/config/saas-billing.php' => config_path('saas-billing.php'),
        ]);
    }

    protected function publishAssets()
    {
        $this->publishes([
            __DIR__ . '/../js/components' => resource_path('vendor/saas-billing/components'),
        ], 'saas-billing-components');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
