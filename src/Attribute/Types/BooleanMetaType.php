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
        if($boolean == 'true')
            $boolean = true;
        else if($boolean == 'false')
            $boolean = false;
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

    /**
     * Get the name of the Meta Type
     * @return string
     */
    public function name(): string
    {
        return 'boolean';
    }
}