<?php

namespace LaravelDocumentedMeta;

use Illuminate\Support\ServiceProvider;
use LaravelDocumentedMeta\Attribute\Types\ArrayMetaType;
use LaravelDocumentedMeta\Attribute\Types\BooleanMetaType;
use LaravelDocumentedMeta\Attribute\Types\FloatMetaType;
use LaravelDocumentedMeta\Attribute\Types\IntegerMetaType;
use LaravelDocumentedMeta\Attribute\Types\ObjectMetaType;
use LaravelDocumentedMeta\Attribute\Types\StringMetaType;
use LaravelDocumentedMeta\Containers\AttributeContainer;
use LaravelDocumentedMeta\Containers\MetaKernel;
use LaravelDocumentedMeta\Storage\Database\DatabaseMetaProvider;
use LaravelDocumentedMeta\Storage\MetaProvider;

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
        $this->app->singleton(MetaProvider::class, DatabaseMetaProvider::class);
        $this->app->singleton(AttributeContainer::class);


        /**
         * Register Types
         */
        $this->app->singleton(ArrayMetaType::class);
        $this->app->singleton(BooleanMetaType::class);
        $this->app->singleton(FloatMetaType::class);
        $this->app->singleton(IntegerMetaType::class);
        $this->app->singleton(ObjectMetaType::class);
        $this->app->singleton(StringMetaType::class);
    }
}