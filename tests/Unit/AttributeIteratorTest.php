<?php

use App\Lib\Arrays\ArrayUtil;
use Illuminate\Support\Collection;
use LaravelDocumentedMeta\AttributeParsing\AttributeIterator;
use PHPUnit\Framework\TestCase;

/**
 * Class AttributeIteratorTest
 */
class AttributeIteratorTest extends TestCase
{
    /**
     * Assert that the iterator can parse through every item and give the correct namespace and class back.
     */
    public function test_parse()
    {

        $user = factory(User::class)->make();
        $parser = new AttributeIterator();
        $possibleNames = new Collection([
            "namespace.test",
            "namespace.namespace_child.test",
            "test"
        ]);
        $originalConfig = [
            "namespace" => [
                MockMetaOption::class,
                "namespace_child" => [
                    MockMetaOption::class
                ]
            ],
            MockMetaOption::class
        ];
        $instance = $parser->parse($originalConfig, function (string $namespace, $class) use (&$possibleNames, $user) {
            $this->assertEquals(MockMetaOption::class, $class);
            $option = new MockMetaOption($user, $namespace);
            $this->assertTrue($possibleNames->contains($option->getName()));
            $possibleNames = $possibleNames->filter(function ($possibleName) use ($option) {
                return !($option->getName() == $possibleName);
            });
            return $class;
        });
        $this->assertTrue(sizeof($possibleNames) == 0);
        $util = new ArrayUtil();
        $this->assertTrue(sizeof($util->arrayRecursiveDiff($originalConfig, $instance)) == 0);
    }


}

