<?php

namespace LaravelDocumentedMeta;

use Illuminate\Contracts\Support\Arrayable;
use LaravelDocumentedMeta\Database\MetaDriver;

/**
 * Class MetaAttribute
 * @package App\Lib\User
 */
abstract class MetaAttribute implements Arrayable
{

    /** @var  HasMeta */
    protected $metaSubject;
    protected $driver;

    /**
     * MetaAttribute constructor.
     * @param MetaDriver $driver
     */
    public function __construct(MetaDriver $driver )
    {
        $this->driver = $driver;
    }

    /**
     * Sets the subject to apply to
     * @param HasMeta|MetaSubject $metaSubject
     */
    public function setSubject(HasMeta $metaSubject) {
        $this->metaSubject = $metaSubject;
    }

    /**
     * The programmatic name for this attribute.
     * @return string
     */
    public abstract function name() : string;


    /**
     * The human readable label for the attribute
     * @return string
     */
    public abstract function label() : string;

    /**
     * The description for this attribute
     * @return string
     */
    public abstract function description() : string;

    /**
     * Gets the default value of this attribute
     * @return mixed
     */
    public abstract function default();

    /**
     * The data type of the attribute. Possible values: "string", "boolean", "array"
     * @return string
     */
    public abstract function type() : string;

    /**
     * Gets the value
     * @return mixed
     */
    public abstract function get();

    /**
     * Sets the value
     * @param $value
     * @return bool
     */
    public abstract function set($value);

    /**
     * Removes the value
     * @return boolean
     */
    public function remove()
    {
        return $this->removeMetaValue();
    }

    /**
     * @param $value
     *
     * @return bool
     */
    protected function saveMetaValue($value) {
        return $this->driver->setMetaValue($this->metaSubject, $this, $value);
    }

    /**
     * Gets a meta value
     * @return null|string
     */
    protected function getMetaValue() {

        return $this->driver->getMetaValue($this->metaSubject, $this);
    }


    /**
     * removes a meta value
     *
     * @return bool|int|null
     */
    protected function removeMetaValue()
    {
        return $this->driver->deleteMetaValue($this->metaSubject, $this);
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
                if($filter($value)) // cecj the filter for a truthy return
                    array_push($savedValues, $value);
            }
            else // no filter given, lets add it in!
                array_push($savedValues, $value);

        return $this->saveMetaValue(json_encode($savedValues));
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
        return $this->saveMetaValue(json_encode($savedValues));
    }


    /**
     * Gets an array from the meta
     *
     * @param array $default
     * @return array|mixed
     */
    protected function getMetaArray($default = []) {
        $value = $this->getMetaValue();
        if(empty($value))
            return $default;
        return json_decode($value, true);
    }


    /**
     * Saves a boolean value to the meta
     *
     * @param bool   $boolean
     *
     * @return bool successful
     */
    protected function saveMetaBoolean(bool $boolean) {
        return $this->saveMetaValue((int)$boolean);
    }

    /**
     * Gets a boolean value from the meta
     *
     *
     * @param bool   $default
     *
     * @return bool
     */
    protected function getMetaBoolean(bool $default = false) : bool {
        $value = $this->getMetaValue();
        if(!isset($value))
            return $default;
        return (bool)$value;
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
        return $this->saveMetaValue(json_encode($savedValues));
    }


    /**
     * Gets the array version of the object
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name(),
            'label' => $this->label(),
            'description' => $this->description(),
            'type' => $this->type(),
            'value' => $this->get(),
            'default' => $this->default()
        ];
    }

}