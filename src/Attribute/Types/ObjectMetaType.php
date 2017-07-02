<?php

namespace LaravelDocumentedMeta\Attribute\Types;

use Illuminate\Contracts\Support\Arrayable;
use stdClass;

class ObjectMetaType extends  MetaType
{
    /**
     * @return array
     */
    public function get() {
        $value = $this->attribute->getRawValue();
        if(is_array($value))
            return $value;
        return  is_null($value) ? $this->default() : json_decode($value, true);
    }

    /**
     * @param array|stdClass|Arrayable  $object
     * @return bool
     */
    public function set($object) : bool {
        if(is_array($object))
            return $this->attribute->setRawValue(json_encode($object));
        if($object instanceof Arrayable)
            return $this->attribute->setRawValue(json_encode($object->toArray()));
        if(is_a($object, stdClass::class))
            return $this->attribute->setRawValue(json_encode($object));
        return false;
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
    public static function name(): string
    {
        return 'object';
    }
}