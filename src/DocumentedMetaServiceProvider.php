<?php

namespace LaravelDocumentedMeta;

use Illuminate\Support\ServiceProvider;
use LaravelDocumentedMeta\Containers\MetaKernel;
use LaravelDocumentedMeta\Database\MetaDriver;

/**
 * Class DocumentedMetaServiceProvider
 * @package LaravelDocumentedMeta
 */
class DocumentedMetaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }

    /**
     * Register any services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MetaKernel::class);
        $this->app->singleton(MetaDriver::class);
    }
}