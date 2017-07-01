<?php

namespace LaravelDocumentedMeta\Attribute\Types;

class FloatMetaType extends MetaType
{
    /**
     * Saves a float value to the meta
     *
     * @param float   $value
     *
     * @return bool successful
     */
    public function set($value) : bool {
        return $this->attribute->setRawValue((float)$value);
    }

    /**
     * Gets a float value from the meta
     *
     * @return float
     */
    public function get() : float {
        return (float)$this->attribute->getRawValue();
    }
}