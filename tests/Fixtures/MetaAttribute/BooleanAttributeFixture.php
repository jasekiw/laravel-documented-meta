<?php

namespace LaravelDocumentedMeta\Tests\Fixtures\MetaAttribute;

use LaravelDocumentedMeta\Attribute\MetaAttribute;
use LaravelDocumentedMeta\Attribute\Types\BooleanMetaType;

class BooleanAttributeFixture extends MetaAttribute
{

    /**
     * The programmatic name for this attribute.
     * @return string
     */
    public function name(): string
    {
        return 'booleanMetaAttribute';
    }

    /**
     * The human readable label for the attribute
     * @return string
     */
    public function label(): string
    {
        return 'Boolean Meta Attribute';
    }

    /**
     * The description for this attribute
     * @return string
     */
    public function description(): string
    {
        return 'a boolean attribute';
    }

    /**
     * The data type of the attribute. Possible values: "string", "boolean", "array"
     * @return string
     */
    public function type(): string
    {
        return BooleanMetaType::class;
    }

    /**
     * Get the possibly values that this meta attribute can have for documentation.
     * @return array
     */
    public function possibleValues(): array
    {
        return [
            true,
            false
        ];
    }
}