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
        return (string)$this->attribute->getRawValue();
    }
}