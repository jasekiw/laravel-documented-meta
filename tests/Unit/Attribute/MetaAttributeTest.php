<?php

namespace LaravelDocumentedMeta\Tests\Unit\Attribute;

use LaravelDocumentedMeta\Storage\ArrayMetaProvider;
use LaravelDocumentedMeta\Tests\Fixtures\MetaAttribute\BooleanAttributeFixture;
use LaravelDocumentedMeta\Tests\Fixtures\MetaAttribute\FloatAttributeFixture;
use LaravelDocumentedMeta\Tests\Fixtures\MetaAttribute\IntegerAttributeFixture;
use LaravelDocumentedMeta\Tests\Fixtures\MetaAttribute\StringAttributeFixture;
use LaravelDocumentedMeta\Tests\TestCase;

class MetaAttributeTest extends TestCase
{
    public function test_getValidator_Integer() {
        $attribute = new IntegerAttributeFixture(new ArrayMetaProvider());
        $validator = $attribute->getValidator(['value' => '2']);
        $this->assertFalse($validator->fails());
        $validator = $attribute->getValidator(['value' =>'2.5']);
        $this->assertTrue($validator->fails());
    }

    public function test_getValidator_String() {
        $attribute = new StringAttributeFixture(new ArrayMetaProvider());
        $validator = $attribute->getValidator(['value' => '2']);
        $this->assertFalse($validator->fails());
        $validator = $attribute->getValidator(['value' => '2.5']);
        $this->assertFalse($validator->fails());
        $validator = $attribute->getValidator(['value' => null ]);
        $this->assertTrue($validator->fails());
    }

    public function test_getValidator_Float() {
        $attribute = new FloatAttributeFixture(new ArrayMetaProvider());
        $validator = $attribute->getValidator(['value' => '2' ]);
        $this->assertFalse($validator->fails());
        $validator = $attribute->getValidator(['value' => '2.5']);
        $this->assertFalse($validator->fails());
        $validator = $attribute->getValidator(['value' => 'hello']);
        $this->assertTrue($validator->fails());
        $this->assertEquals( 'The value must be a float', $validator->errors()->get('value')[0]);
    }

    public function test_getValidator_Boolean() {
        $attribute = new BooleanAttributeFixture(new ArrayMetaProvider());
        $validator = $attribute->getValidator(['value' => 'true']);
        $this->assertFalse($validator->fails());
        $validator = $attribute->getValidator(['value' => 'false']);
        $this->assertFalse($validator->fails());
        $validator = $attribute->getValidator(['value' => 'hello']);
        $this->assertTrue($validator->fails());
        $this->assertEquals( 'The value must be a boolean', $validator->errors()->get('value')[0]);
    }
}