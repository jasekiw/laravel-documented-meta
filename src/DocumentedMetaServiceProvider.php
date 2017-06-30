<?php

namespace LaravelDocumentedMeta;

use Illuminate\Support\ServiceProvider;

class DocumentedMetaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MetaKernel::class);
    }
}