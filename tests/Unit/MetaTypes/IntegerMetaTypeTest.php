<?php

namespace LaravelDocumentedMeta\Tests\Unit\MetaTypes;

use LaravelDocumentedMeta\Attribute\MetaAttribute;
use LaravelDocumentedMeta\Attribute\Types\IntegerMetaType;
use LaravelDocumentedMeta\Tests\TestCase;
use Mockery;
use Mockery\MockInterface;

class IntegerMetaTypeTest extends TestCase
{
    /** @var  MockInterface  */
    protected $attribute;

    protected function setUp()
    {
        parent::setUp();
        $this->attribute = Mockery::mock(MetaAttribute::class);

    }

    public function test_get() {
        $this->attribute->shouldReceive('getRawValue')->andReturn('1');
        $int = new IntegerMetaType($this->attribute);
        $this->assertTrue($int->get() === 1);
    }


}