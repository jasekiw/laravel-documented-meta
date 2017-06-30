<?php

namespace LaravelDocumentedMeta\Tests\Unit;


use LaravelDocumentedMeta\Containers\MetaTypeContainer;
use LaravelDocumentedMeta\Contracts\HasMeta;
use LaravelDocumentedMeta\Tests\Fixtures\MetaAttributeFixture;
use LaravelDocumentedMeta\Tests\TestCase;


class MetaTypeContainerTest extends TestCase
{
    public function test_getAttributeByClass() {

        $metaSubject = \Mockery::mock(HasMeta::class);
        $metaSubject->shouldReceive('getAttributes')->andReturn([
            'namespace' => [MetaAttributeFixture::class]
        ]);
        $config = new MetaTypeContainer($metaSubject);
        $attribute = $config->getAttributeByClass(MetaAttributeFixture::class);
        $this->assertTrue(is_a($attribute->getAttribute(), MetaAttributeFixture::class));
        $this->assertEquals('namespace.testOption', $attribute->getName());

    }

    public function test_getNameSpacedConfig() {
        $metaSubject = \Mockery::mock(HasMeta::class);
        $metaSubject->shouldReceive('getAttributes')->andReturn([
            'namespace' => [MetaAttributeFixture::class]
        ]);
        $metaSubject->shouldReceive('getMetaSubjectId')->andReturn(1);
        $metaSubject->shouldReceive('getMetaTypeName')->andReturn('test');
        $config = new MetaTypeContainer($metaSubject);
        $all = $config->getNameSpacedConfig($metaSubject);
        $this->assertEquals('testOption', $all['namespace'][0]['name'], "The attribute name should be testOption");
    }

    public function test_getAllMetaConfig() {
        $metaSubject = \Mockery::mock(HasMeta::class);
        $metaSubject->shouldReceive('getAttributes')->andReturn([
            'namespace' => [MetaAttributeFixture::class]
        ]);
        $metaSubject->shouldReceive('getMetaSubjectId')->andReturn(1);
        $metaSubject->shouldReceive('getMetaTypeName')->andReturn('test');
        $config = new MetaTypeContainer($metaSubject);
        $all = $config->getAllMetaConfig($metaSubject);
        $this->assertEquals('testOption', $all['nested']['namespace'][0]['name'], "The attribute name should be testOption");
        $this->assertEquals('namespace.testOption', $all['flat'][0]['name'], "The attribute name should be testOption");
    }

    public function test_setMetaValue_getMetaValue() {
        /** @var mixed $metaSubject */
        $metaSubject = \Mockery::mock(HasMeta::class);
        $metaSubject->shouldReceive('getAttributes')->andReturn([
            'namespace' => [MetaAttributeFixture::class]
        ]);
        $metaSubject->shouldReceive('getMetaSubjectId')->andReturn(1);
        $metaSubject->shouldReceive('getMetaTypeName')->andReturn('test');
        $config = new MetaTypeContainer($metaSubject);
        $config->setMetaValue(MetaAttributeFixture::class, $metaSubject, 'hi');
        $attributeValue = $config->getMetaValue(MetaAttributeFixture::class, $metaSubject);
        $this->assertEquals('hi', $attributeValue, "The attribute should return it's default value");
    }
}