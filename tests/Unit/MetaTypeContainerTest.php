<?php

namespace LaravelDocumentedMeta\Tests\Unit;


use LaravelDocumentedMeta\Containers\AttributeContainer;
use LaravelDocumentedMeta\Containers\MetaSubjectContainer;
use LaravelDocumentedMeta\Contracts\HasMeta;
use LaravelDocumentedMeta\Tests\Fixtures\StringAttributeFixture;
use LaravelDocumentedMeta\Tests\TestCase;


class MetaTypeContainerTest extends TestCase
{
    public function test_getAttributeByClass() {

        $metaSubject = \Mockery::mock(HasMeta::class);
        $metaSubject->shouldReceive('getMetaAttributes')->andReturn([
            'namespace' => [StringAttributeFixture::class]
        ]);
        $config = new MetaSubjectContainer($metaSubject, new AttributeContainer());
        $attribute = $config->getAttributeByClass(StringAttributeFixture::class);
        $this->assertTrue(is_a($attribute->getAttribute(), StringAttributeFixture::class));
        $this->assertEquals('namespace.testOption', $attribute->getName());

    }

    public function test_getNameSpacedConfig() {
        $metaSubject = \Mockery::mock(HasMeta::class);
        $metaSubject->shouldReceive('getMetaAttributes')->andReturn([
            'namespace' => [StringAttributeFixture::class]
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
            'namespace' => [StringAttributeFixture::class]
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
            'namespace' => [StringAttributeFixture::class]
        ]);
        $metaSubject->shouldReceive('getMetaSubjectId')->andReturn(1);
        $metaSubject->shouldReceive('getMetaTypeName')->andReturn('test');
        $config = new MetaSubjectContainer($metaSubject, new AttributeContainer());
        $config->setMetaValue(StringAttributeFixture::class, $metaSubject, 'hi');
        $attributeValue = $config->getMetaValue(StringAttributeFixture::class, $metaSubject);
        $this->assertEquals('hi', $attributeValue, "The attribute should return it's default value");
    }
}