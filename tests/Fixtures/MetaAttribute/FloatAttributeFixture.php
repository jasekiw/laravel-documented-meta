<?php

namespace LaravelDocumentedMeta\Tests\Fixtures\MetaAttribute;

use LaravelDocumentedMeta\Attribute\MetaAttribute;
use LaravelDocumentedMeta\Attribute\Types\FloatMetaType;

class FloatAttributeFixture extends MetaAttribute
{

    /**
     * The programmatic name for this attribute.
     * @return string
     */
    public function name(): string
    {
        return 'floatAttribute';
    }

    /**
     * The human readable label for the attribute
     * @return string
     */
    public function label(): string
    {
        return 'Float Attribute';
    }

    /**
     * The description for this attribute
     * @return string
     */
    public function description(): string
    {
        return 'A float attribute';
    }

    /**
     * The data type of the attribute. Possible values: "string", "boolean", "array"
     * @return string
     */
    public function type(): string
    {
        return FloatMetaType::class;
    }

    /**
     * Get the possibly values that this meta attribute can have for documentation.
     * @return array
     */
    public function possibleValues(): array
    {
        return [
            'between 0 and 999'
        ];
    }
}