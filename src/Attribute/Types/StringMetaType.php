<?php

namespace LaravelDocumentedMeta\Attribute\Types;

class StringMetaType extends MetaType
{

    /**
     * @param $value
     *
     * @return bool
     */
    public function set($value) : bool {
        return $this->attribute->setRawValue((string)$value);
    }

    /**
     * Gets a meta value
     * @return null|string
     */
    public function get() {
        $value = $this->attribute->getRawValue();
        return is_null($value) ? $this->default() : $value;
    }

    /**
     * Gets the default value of this type
     * @return mixed
     */
    public function default()
    {
        return '';
    }

    /**
     * Get the name of the Meta Type
     * @return string
     */
    public function name(): string
    {
        return 'string';
    }
}