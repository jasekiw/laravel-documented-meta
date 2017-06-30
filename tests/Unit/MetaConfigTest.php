<?php
namespace LaravelDocumentedMeta\Tests\Unit;

use LaravelDocumentedMeta\AttributeParsing\MetaCache;
use LaravelDocumentedMeta\Tests\TestCase;

class MetaConfigTest extends TestCase
{
    /**
     * test that the toArray method gives array representations
     */
    function test_toArray() {
        $originalConfig = [
            "namespace" => [
                new MetaOptionFixture(null, ''),
                "namespace_child" => [
                    new MetaOptionFixture(null, '')
                ]
            ],
            new MetaOptionFixture(null, '')
        ];
        $config = (new MetaCache($originalConfig))->toArray();
        array_walk_recursive($config, function($value) {
            $this->assertTrue(is_array($value) || is_string($value));
        });
    }
}