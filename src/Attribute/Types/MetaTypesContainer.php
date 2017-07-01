<?php

namespace LaravelDocumentedMeta\Attribute\Types;

class MetaTypesContainer
{
    private $types = [];
    public function __construct(  ArrayMetaType $array,
                                  BooleanMetaType $boolean,
                                  FloatMetaType $float,
                                  IntegerMetaType $int,
                                  ObjectMetaType $object,
                                  StringMetaType $string)
    {

    }


}