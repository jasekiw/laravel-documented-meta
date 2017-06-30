<?php
namespace LaravelDocumentedMeta\Tests\Unit;


use Illuminate\Support\Collection;
use LaravelDocumentedMeta\Tests\ArrayUtil;
use LaravelDocumentedMeta\Attribute\AttributeIterator;
use LaravelDocumentedMeta\Tests\TestCase;


/**
 * Class AttributeIteratorTest
 */
class AttributeIteratorTest extends TestCase
{
    /**
     * Assert that the iterator can parse through every
     * item and give the correct namespace and name back
     */
    public function test_parse()
    {
        $parser = new AttributeIterator();
        $possibleNames = new Collection([
            "namespace.test1",
            "namespace.namespace_child.test2",
            "test3"
        ]);
        $originalConfig = [
            "namespace" => [
                'test1',
                "namespace_child" => [
                    'test2'
                ]
            ],
            'test3'
        ];
        $instance = $parser->parse($originalConfig, function (string $namespace, $class) use (&$possibleNames) {
            $this->assertTrue($possibleNames->contains((!empty($namespace) ? $namespace . '.' : '') . $class));
            $possibleNames = $possibleNames->filter(function ($possibleName) use ($namespace, $class) {
                return !(((!empty($namespace) ? $namespace . '.' : '') . $class) == $possibleName);
            });
            return $class;
        });
        $this->assertTrue(sizeof($possibleNames) == 0);
        $util = new ArrayUtil();
        $this->assertTrue(sizeof($util->arrayRecursiveDiff($originalConfig, $instance)) == 0);
    }


}

