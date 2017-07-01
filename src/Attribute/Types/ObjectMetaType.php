<?php

namespace LaravelDocumentedMeta\Attribute\Types;

use Illuminate\Contracts\Support\Arrayable;
use stdClass;

class ObjectMetaType extends  MetaType
{
    /**
     * @return array|null
     */
    public function get() {
        $value = $this->attribute->getRawValue();
        if(is_array($value))
            return $value;
        return json_decode($value, true);
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


}