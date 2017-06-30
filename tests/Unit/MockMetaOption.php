<?php
namespace LaravelDocumentedMeta\Tests\Unit;

/**
 * Class MockMetaOption
 * Meta Option Mock
 */
class MockMetaOption
{
    protected $nameSpace;

    function __construct($user, $nameSpace) {
        $this->nameSpace = $nameSpace;
    }

    public function getName() : string
    {
        return ($this->nameSpace == "" ? "" : $this->nameSpace  . ".") . "test";
    }

    public function toArray() {
        return [
            "name" => "test"
        ];
    }
}