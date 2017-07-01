<?php

namespace LaravelDocumentedMeta\Tests\Unit;


use LaravelDocumentedMeta\Containers\AttributeContainer;
use LaravelDocumentedMeta\Containers\MetaSubjectContainer;
use LaravelDocumentedMeta\Contracts\HasMeta;
use LaravelDocumentedMeta\Tests\Fixtures\MetaAttributeFixture;
use LaravelDocumentedMeta\Tests\TestCase;


class MetaTypeContainerTest extends TestCase
{
    public function test_getAttributeByClass() {

        $metaSubject = \Mockery::mock(HasMeta::class);
        $metaSubject->shouldReceive('getMetaAttributes')->andReturn([
            'namespace' => [MetaAttributeFixture::class]
        ]);
        $config = new MetaSubjectContainer($metaSubject, new AttributeContainer());
        $attribute = $config->getAttributeByClass(MetaAttributeFixture::class);
        $this->assertTrue(is_a($attribute->getAttribute(), MetaAttributeFixture::class));
        $this->assertEquals('namespace.testOption', $attribute->getName());

    }

    public function test_getNameSpacedConfig() {
        $metaSubject = \Mockery::mock(HasMeta::class);
        $metaSubject->shouldReceive('getMetaAttributes')->andReturn([
            'namespace' => [MetaAttributeFixture::class]
        ]);
        $metaSubject->shouldReceive('getMetaSubjectId')->andReturn(1);
        $metaSubject->shouldReceive('getMetaTypeName')->andReturn('test');
        $config = new MetaSubjectContainer($metaSubject, new AttributeContainer());
        $all = $config->getNameSpacedConfig($metaSubject);
        $this->assertEquals('testOption', $all['namespace'][0]['name'], "The attribute name should be testOption");
    }

    public function test_getAllMetaConfig() {
        $metaSubject = \Mockery::mock(HasMeta::class);
        $metaSubject->shouldReceive('getMetaAttributes')->andReturn([
            'namespace' => [MetaAttributeFixture::class]
        ]);
        $metaSubject->shouldReceive('getMetaSubjectId')->andReturn(1);
        $metaSubject->shouldReceive('getMetaTypeName')->andReturn('test');
        $config = new MetaSubjectContainer($metaSubject, new AttributeContainer());
        $all = $config->getAllMetaConfig($metaSubject);
        $this->assertEquals('testOption', $all['nested']['namespace'][0]['name'], "The attribute name should be testOption");
        $this->assertEquals('namespace.testOption', $all['flat'][0]['name'], "The attribute name should be testOption");
    }

    public function test_setMetaValue_getMetaValue() {
        /** @var mixed $metaSubject */
        $metaSubject = \Mockery::mock(HasMeta::class);
        $metaSubject->shouldReceive('getMetaAttributes')->andReturn([
            'namespace' => [MetaAttributeFixture::class]
        ]);
        $metaSubject->shouldReceive('getMetaSubjectId')->andReturn(1);
        $metaSubject->shouldReceive('getMetaTypeName')->andReturn('test');
        $config = new MetaSubjectContainer($metaSubject, new AttributeContainer());
        $config->setMetaValue(MetaAttributeFixture::class, $metaSubject, 'hi');
        $attributeValue = $config->getMetaValue(MetaAttributeFixture::class, $metaSubject);
        $this->assertEquals('hi', $attributeValue, "The attribute should return it's default value");
    }
}