<?php

namespace LaravelDocumentedMeta\Attribute\Types;

class ArrayMetaType extends MetaType
{


    /**
     * @param array         $values
     * @param callable|null $filter ($value) : boolean
     *
     * @return bool
     */
    public function setArray(array $values, $filter = null) {
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

        return $this->attribute->setRawValue(json_encode($savedValues));
    }

    public function set($array) : bool {
        return $this->setArray($array);
    }


    /**
     * @param array         $values
     * @param callable|null $filter ($value) : boolean
     *
     * @return bool
     */
    public function mergeArray(array $values, $filter = null) {
        $values = array_values($values); // strip out any key associations
        $savedValues = $this->get();
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
        return $this->attribute->setRawValue(json_encode($savedValues));
    }



    /**
     * Remove the given values from the stored array
     * @param array  $values
     *
     * @return bool
     */
    public function removeValues(array $values)
    {
        $valuesToRemove = array_values($values); // strip out any key associations
        $savedValues = $this->get();
        // ouch that time complexity! O(N^2) around 47 milliseconds worse case scenario. around 212521 total iterations worse case
        foreach ($valuesToRemove as $valueToRemove)
            if(in_array($valueToRemove,$savedValues))
                foreach($savedValues as $key => $savedValue)
                    if($savedValue == $valueToRemove)
                        unset($savedValues[$key]);
        return $this->attribute->setRawValue(json_encode($savedValues));
    }


    /**
     * Gets an array from the meta
     *
     * @return array|mixed
     */
    public function get() {
        $value = $this->attribute->getRawValue();
        if(is_array($value))
            return $value;
        if(is_null($value))
            return $this->default();
        return json_decode($value, true);
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
    public function name(): string
    {
        return 'array';
    }
}