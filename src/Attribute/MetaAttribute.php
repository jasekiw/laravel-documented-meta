<?php

namespace LaravelDocumentedMeta\Attribute;

use Illuminate\Contracts\Support\Arrayable;
use LaravelDocumentedMeta\Contracts\HasMeta;
use LaravelDocumentedMeta\Storage\Database\DatabaseMetaProvider;
use LaravelDocumentedMeta\Concerns\RetrievesMeta;

/**
 * Class MetaAttribute
 * @package App\Lib\User
 */
abstract class MetaAttribute implements Arrayable
{

    /**
     * @var  HasMeta
     */
    protected $metaSubject;

    /**
     * @var DatabaseMetaProvider
     */
    protected $driver;

    /**
     * MetaAttribute constructor.
     * @param DatabaseMetaProvider $driver
     */
    public function __construct(DatabaseMetaProvider $driver )
    {
        $this->driver = $driver;
    }

    /**
     * Sets the subject to apply this meta to
     * @param HasMeta $metaSubject
     * @return $this
     */
    public function setSubject(HasMeta $metaSubject) {
        $this->metaSubject = $metaSubject;
        return $this;
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
     * Get the possibly values that this meta attribute can have for documentation.
     * @return array
     */
    public abstract function possibleValues() : array;

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
        return $this->driver->deleteMetaValue($this->metaSubject, $this);
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public function saveStringValue($value) {
        return $this->driver->setMetaValue($this->metaSubject, $this, $value);
    }

    /**
     * Gets a meta value
     * @return null|string
     */
    public function getStringValue() {

        return $this->driver->getMetaValue($this->metaSubject, $this);
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
            'possibleValues' => json_encode($this->possibleValues()),
            'value' => $this->get(),
            'default' => $this->default()
        ];
    }

}