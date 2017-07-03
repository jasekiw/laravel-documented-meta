<?php

namespace LaravelDocumentedMeta\Tests\Fixtures\MetaAttribute;

use LaravelDocumentedMeta\Attribute\MetaAttribute;
use LaravelDocumentedMeta\Attribute\Types\IntegerMetaType;

class IntegerAttributeFixture  extends MetaAttribute
{

    /**
     * The programmatic name for this attribute.
     * @return string
     */
    public function name(): string
    {
        return 'integerAttributeFixture';
    }

    /**
     * The human readable label for the attribute
     * @return string
     */
    public function label(): string
    {
        return 'Integer Attribute Fixture';
    }

    /**
     * The description for this attribute
     * @return string
     */
    public function description(): string
    {
       return 'foo';
    }


    /**
     * The data type of the attribute. Possible values: "string", "boolean", "array"
     * @return string
     */
    public function type(): string
    {
        return IntegerMetaType::class;
    }

    /**
     * Get the possibly values that this meta attribute can have for documentation.
     * @return array
     */
    public function possibleValues(): array
    {
        return [0,1,2,3,4];
    }

}