<?php

namespace LaravelDocumentedMeta\Tests\Unit;


use LaravelDocumentedMeta\AttributeParsing\MetaCache;
use LaravelDocumentedMeta\HasMeta;
use LaravelDocumentedMeta\MetaOption;
use LaravelDocumentedMeta\Tests\TestCase;


class MetaCacheTest extends TestCase
{
    public function test_getAttributeByClass() {
        $metaSubject = \Mockery::mock(HasMeta::class);
        $metaAttribute = \Mockery::mock(MetaOption::class);
        $metaAttribute->shouldReceive();
        $metaSubject->shouldReceive('getAttributes')->andReturn([
            MetaOptionFixture::class
        ]);
        $config = new MetaCache($metaSubject);
    }
}