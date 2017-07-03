<?php

namespace LaravelDocumentedMeta\Tests\Unit\Attribute\Types;

use LaravelDocumentedMeta\Attribute\MetaAttribute;
use LaravelDocumentedMeta\Attribute\Types\BooleanMetaType;
use LaravelDocumentedMeta\Tests\TestCase;
use Mockery;

class BooleanMetaTypeTest extends TestCase
{

    public function test_set_string_false() {
        $attribute = Mockery::mock(MetaAttribute::class);
        $attribute->shouldReceive('setRawValue')->with('0')->andReturn(true);
        $type  = new BooleanMetaType($attribute);
        $type->set('false');
    }

    public function test_set_string_true() {
        $attribute = Mockery::mock(MetaAttribute::class);
        $attribute->shouldReceive('setRawValue')->with('1')->andReturn(true);
        $type  = new BooleanMetaType($attribute);
        $type->set('true');
    }

}