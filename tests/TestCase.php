<?php
namespace LaravelDocumentedMeta\Tests;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Connection;
use Illuminate\Validation\ValidationServiceProvider;
use LaravelDocumentedMeta\DocumentedMetaServiceProvider;
use LaravelDocumentedMeta\Storage\ArrayMetaProvider;
use LaravelDocumentedMeta\Storage\MetaProvider;
use Mockery;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{


    protected function setUp()
    {
        parent::setUp();
        $this->artisan('migrate', ['--database' => 'testbench']);
        app()->singleton(MetaProvider::class, ArrayMetaProvider::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            DocumentedMetaServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }
}