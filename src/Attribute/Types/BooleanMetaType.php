<?php

namespace LaravelDocumentedMeta\Attribute\Types;

class BooleanMetaType extends MetaType
{

    /**
     * Saves a boolean value to the meta
     *
     * @param bool   $boolean
     *
     * @return bool successful
     */
    public function set($boolean) : bool {
        return $this->attribute->setRawValue((int)((bool)$boolean));
    }

    /**
     * Gets a boolean value from the meta
     *
     * @return bool
     */
    public function get() : bool {
        return (bool)$this->attribute->getRawValue();
    }

    /**
     * Gets the default value of this type
     * @return mixed
     */
    public function default()
    {
        return [];
    }
}