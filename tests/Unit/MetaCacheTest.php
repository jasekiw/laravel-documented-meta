<?php

namespace LaravelDocumentedMeta\Tests\Unit;


use LaravelDocumentedMeta\AttributeParsing\MetaCache;
use LaravelDocumentedMeta\HasMeta;
use LaravelDocumentedMeta\Tests\TestCase;


class MetaCacheTest extends TestCase
{
    public function test_getAttributeByClass() {

        $metaSubject = \Mockery::mock(HasMeta::class);
        $metaSubject->shouldReceive('getAttributes')->andReturn([
            'namespace' => [MetaOptionFixture::class]
        ]);
        $config = new MetaCache($metaSubject);
        $attribute = $config->getAttributeByClass(MetaOptionFixture::class);
        $this->assertTrue(is_a($attribute->getAttribute(), MetaOptionFixture::class));
        $this->assertEquals('namespace.testOption', $attribute->getName());

    }

    public function test_getNameSpacedConfig() {
        $metaSubject = \Mockery::mock(HasMeta::class);
        $metaSubject->shouldReceive('getAttributes')->andReturn([
            'namespace' => [MetaOptionFixture::class]
        ]);
        $metaSubject->shouldReceive('getMetaSubjectId')->andReturn(1);
        $metaSubject->shouldReceive('getMetaTypeName')->andReturn('test');
        $config = new MetaCache($metaSubject);
        $all = $config->getNameSpacedConfig($metaSubject);
        $this->assertEquals('testOption', $all['namespace'][0]['name'], "The attribute name should be testOption");
    }

    public function test_getAllMetaConfig() {
        $metaSubject = \Mockery::mock(HasMeta::class);
        $metaSubject->shouldReceive('getAttributes')->andReturn([
            'namespace' => [MetaOptionFixture::class]
        ]);
        $metaSubject->shouldReceive('getMetaSubjectId')->andReturn(1);
        $metaSubject->shouldReceive('getMetaTypeName')->andReturn('test');
        $config = new MetaCache($metaSubject);
        $all = $config->getAllMetaConfig($metaSubject);
        $this->assertEquals('testOption', $all['nested']['namespace'][0]['name'], "The attribute name should be testOption");
        $this->assertEquals('namespace.testOption', $all['flat'][0]['name'], "The attribute name should be testOption");
    }
}