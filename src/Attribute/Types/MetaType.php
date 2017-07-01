<?php

namespace LaravelDocumentedMeta\Attribute\Types;

use LaravelDocumentedMeta\Attribute\MetaAttribute;

abstract class MetaType
{
    protected $attribute;

    public function __construct(MetaAttribute $attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * Get the value
     * @return mixed The value
     */
    public abstract function get();

    /**
     * Set the value
     * @param mixed $value
     * @return bool successful
     */
    public abstract function set($value) : bool;

    /**
     * Gets the default value of this type
     * @return mixed
     */
    public abstract function default();
}