<?php
namespace LaravelDocumentedMeta\Tests;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Connection;
use LaravelDocumentedMeta\DocumentedMetaServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{


    protected function setUp()
    {
        parent::setUp();
        $this->artisan('migrate', ['--database' => 'testbench']);
    }

    protected function getPackageProviders($app)
    {
        return [DocumentedMetaServiceProvider::class];
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

}