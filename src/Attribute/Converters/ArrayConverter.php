<?php

namespace LaravelDocumentedMeta\Attribute\Converters;

use LaravelDocumentedMeta\Attribute\MetaAttribute;

class ArrayConverter
{
    protected $attribute;

    public function __construct(MetaAttribute $attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * @param array         $values
     * @param callable|null $filter ($value) : boolean
     *
     * @return bool
     */
    protected function saveMetaArray( array $values, $filter = null) {
        $values = array_values($values); // strip out any key associations
        $savedValues = [];
        foreach ($values as $value) // loop through the new items to make sure they can go in the database
            if(isset($filter) && is_callable($filter)) // if a filter is given
            {
                if($filter($value)) // call the filter toe check whether it is allowed
                    array_push($savedValues, $value);
            }
            else // no filter is given, lets add it in!
                array_push($savedValues, $value);

        return $this->attribute->saveStringValue(json_encode($savedValues));
    }

    /**
     * @param array         $values
     * @param callable|null $filter ($value) : boolean
     *
     * @return bool
     */
    protected function saveOrAddMetaArray( array $values, $filter = null) {
        $values = array_values($values); // strip out any key associations
        $savedValues = $this->getMetaArray();
        foreach ($values as $value) // loop through the new items to make sure they can go in the database
            if(!in_array($value, $savedValues)) // not already saved
            {
                if(isset($filter) && is_callable($filter)) // if a filter is given
                {
                    if($filter($value)) // call the filter for a truthy return
                        array_push($savedValues, $value);
                }
                else // no filter given, lets add it in!
                    array_push($savedValues, $value);
            }
        return $this->attribute->saveStringValue(json_encode($savedValues));
    }



    /**
     * @param array  $values
     *
     * @return bool
     */
    protected function removeMetaArrayValues(array $values)
    {
        $valuesToRemove = array_values($values); // strip out any key associations
        $savedValues = $this->getMetaArray();
        // ouch that time complexity! O(N^2) around 47 milliseconds worse case scenario. around 212521 total iterations worse case
        foreach ($valuesToRemove as $valueToRemove)
            if(in_array($valueToRemove,$savedValues))
                foreach($savedValues as $key => $savedValue)
                    if($savedValue == $valueToRemove)
                        unset($savedValues[$key]);
        return $this->attribute->saveStringValue(json_encode($savedValues));
    }


    /**
     * Gets an array from the meta
     *
     * @param array $default
     * @return array|mixed
     */
    protected function getMetaArray($default = []) {
        $value = $this->attribute->getStringValue();
        if(empty($value))
            return $default;
        return json_decode($value, true);
    }
}