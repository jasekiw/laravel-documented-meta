<?php

namespace LaravelDocumentedMeta\Tests\Fixtures;

use LaravelDocumentedMeta\Attribute\MetaAttribute;
use LaravelDocumentedMeta\Attribute\MetaValueType;

/**
 * Class MetaAttributeFixture
 * Meta Option Mock
 */
class MetaAttributeFixture extends MetaAttribute
{


    /**
     * The programmatic name for this attribute.
     * @return string
     */
    public function name(): string
    {
        return 'testOption';
    }

    /**
     * The human readable label for the attribute
     * @return string
     */
    public function label(): string
    {
        return 'Test Option';
    }

    /**
     * The description for this attribute
     * @return string
     */
    public function description(): string
    {
        return 'Some Description';
    }

    /**
     * Gets the default value of this attribute
     * @return mixed
     */
    public function default()
    {
        return 'none';
    }

    /**
     * The data type of the attribute. Possible values: "string", "boolean", "array"
     * @return string
     */
    public function type(): string
    {
        return MetaValueType::STRING;
    }

    /**
     * Gets the value
     * @return string
     */
    public function get()
    {
        return $this->getStringValue();
    }

    /**
     * The value can only be the allowed authentication methods
     * @param string $value
     * @return bool
     */
    public function set($value)
    {
        return $this->saveStringValue($value);
    }

    /**
     * Get the possibly values that this meta attribute can have for documentation.
     * @return array
     */
    public function possibleValues(): array
    {
        return [
            'none',
            'test'
        ];
    }
}