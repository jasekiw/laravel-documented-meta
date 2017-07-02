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
        $value = $this->attribute->getRawValue();
        return  is_null($value) ? $this->default() : (float) $value;
    }

    /**
     * Gets the default value of this type
     * @return mixed
     */
    public function default()
    {
        return 0.0;
    }

    /**
     * Get the name of the Meta Type
     * @return string
     */
    public static function name(): string
    {
        return 'float';
    }
}