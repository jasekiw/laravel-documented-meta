<?php

namespace LaravelDocumentedMeta\Attribute\Converters;

use LaravelDocumentedMeta\Attribute\MetaAttribute;

class BooleanConverter
{
    protected $attribute;

    public function __construct(MetaAttribute $attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * Saves a boolean value to the meta
     *
     * @param bool   $boolean
     *
     * @return bool successful
     */
    protected function saveBoolean(bool $boolean) {
        return $this->attribute->saveStringValue((int)$boolean);
    }

    /**
     * Gets a boolean value from the meta
     *
     * @return bool
     */
    protected function getMetaBoolean() : bool {
        return (bool)$this->attribute->getStringValue();
    }

}