<?php
namespace LaravelDocumentedMeta\Tests\Unit;

use LaravelDocumentedMeta\AttributeParsing\Config;
use LaravelDocumentedMeta\Tests\TestCase;

class MetaConfigTest extends TestCase
{
    /**
     * test that the toArray method gives array representations
     */
    function test_toArray() {
        $originalConfig = [
            "namespace" => [
                new MockMetaOption(null, ''),
                "namespace_child" => [
                    new MockMetaOption(null, '')
                ]
            ],
            new MockMetaOption(null, '')
        ];
        $config = (new Config($originalConfig))->toArray();
        array_walk_recursive($config, function($value) {
            $this->assertTrue(is_array($value) || is_string($value));
        });
    }
}