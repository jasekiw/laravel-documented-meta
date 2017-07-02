<?php

namespace LaravelDocumentedMeta\Attribute\Types;

class IntegerMetaType extends MetaType
{
    /**
     * Saves a int value to the meta
     *
     * @param integer   $value
     *
     * @return bool successful
     */
    public function set($value) : bool {
        return $this->attribute->setRawValue((int)$value);
    }

    /**
     * Gets a int value from the meta
     *
     * @return int
     */
    public function get() : int {
        $value = $this->attribute->getRawValue();
        return is_null($value) ? $this->default() : (int)$value;
    }

    /**
     * Gets the default value of this type
     * @return mixed
     */
    public function default()
    {
        return 0;
    }

    /**
     * Get the name of the Meta Type
     * @return string
     */
    public static function name(): string
    {
        return 'int';
    }
}