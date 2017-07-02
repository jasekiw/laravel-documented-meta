<?php

namespace LaravelDocumentedMeta\Tests\Unit\Storage;

use LaravelDocumentedMeta\Storage\Database\DatabaseMetaProvider;
use LaravelDocumentedMeta\Tests\Fixtures\Subject\SubjectWithParentFixture;
use LaravelDocumentedMeta\Tests\TestCase;

class DatabaseMetaProviderTest extends TestCase
{
    /**
     * @var DatabaseMetaProvider
     */
    protected $provider;

    /**
     * @var SubjectWithParentFixture
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->provider = new DatabaseMetaProvider();
        $this->subject = new SubjectWithParentFixture();
    }

    /**
     * The default should always be returned if the attribute does not exist
     */
    public function test_getMetValue_default() {
        $this->assertEquals('test',$this->provider->getMetaValue($this->subject, 'test', 'test'));
    }


}