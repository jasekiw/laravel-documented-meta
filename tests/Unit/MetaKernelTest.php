<?php

namespace LaravelDocumentedMeta\Tests\Unit;


use LaravelDocumentedMeta\AttributeParsing\MetaCache;
use LaravelDocumentedMeta\HasMeta;
use LaravelDocumentedMeta\MetaKernel;
use LaravelDocumentedMeta\Tests\Fixtures\MetaSubjectFixture;
use LaravelDocumentedMeta\Tests\TestCase;

class MetaKernelTest extends TestCase
{
    public function test_getKernel() {
        $kernel = app()->make(MetaKernel::class);
        $this->assertTrue($kernel === app()->make(MetaKernel::class), "The meta kernel should be a singleton");
    }

    public function test_getMetaCache() {
        $kernel = new MetaKernel();
        $subject = new MetaSubjectFixture();
        $subject2 = new MetaSubjectFixture();
        $subject3 = \Mockery::mock(HasMeta::class);
        $subject3->shouldReceive('getAttributes')->andReturn([]);
        $config = $kernel->getMetaConfig($subject);
        $this->assertTrue(is_a($config, MetaCache::class));
        $this->assertTrue($config === $kernel->getMetaConfig($subject2), 'Instances from the same class should receive the same configuration');
        $this->assertFalse($config === $kernel->getMetaConfig($subject3), 'Instances from a different class should receive a new configuration');
    }
}