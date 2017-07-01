<?php

namespace LaravelDocumentedMeta\Containers;

use LaravelDocumentedMeta\Attribute\MetaAttribute;

class AttributeContainer
{
    protected $attributes = [];

    /**
     * Registers an Attribute and retrieves it.
     * @param $attribute
     * @return MetaAttribute
     */
    public function register($attribute) {
        if(isset($this->attributes[$attribute]))
            return $this->attributes[$attribute];
        $this->attributes[$attribute] = app()->make($attribute);
        return $this->attributes[$attribute];
    }
}