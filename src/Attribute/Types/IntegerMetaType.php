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
        return (int)$this->attribute->getRawValue();
    }
}