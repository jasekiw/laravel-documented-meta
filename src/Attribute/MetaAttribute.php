<?php

namespace LaravelDocumentedMeta\Attribute;

use Illuminate\Contracts\Support\Arrayable;
use LaravelDocumentedMeta\Attribute\Types\ArrayMetaType;
use LaravelDocumentedMeta\Attribute\Types\BooleanMetaType;
use LaravelDocumentedMeta\Attribute\Types\FloatMetaType;
use LaravelDocumentedMeta\Attribute\Types\IntegerMetaType;
use LaravelDocumentedMeta\Attribute\Types\MetaType;
use LaravelDocumentedMeta\Attribute\Types\ObjectMetaType;
use LaravelDocumentedMeta\Attribute\Types\StringMetaType;
use LaravelDocumentedMeta\Contracts\HasMeta;
use LaravelDocumentedMeta\Storage\ArrayMetaProvider;
use LaravelDocumentedMeta\Storage\Database\DatabaseMetaProvider;
use LaravelDocumentedMeta\Concerns\RetrievesMeta;
use LaravelDocumentedMeta\Storage\MetaProvider;

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
     * @var MetaProvider
     */
    protected $driver;

    /** @var  ArrayMetaType  */
    protected $array;
    /** @var  BooleanMetaType */
    protected $boolean;
    /** @var  FloatMetaType */
    protected $float;
    /** @var  IntegerMetaType */
    protected $int;
    /** @var  ObjectMetaType */
    protected $object;
    /** @var  StringMetaType */
    protected $string;
    /** @var MetaType[] */
    private $types = [];
    /**
     * MetaAttribute constructor.
     * @param MetaProvider $driver

     */
    public function __construct(MetaProvider $driver)
    {
        $this->driver = $driver;
        $this->array = new ArrayMetaType($this);
        $this->types[ArrayMetaType::class] = $this->array;
        $this->boolean = new BooleanMetaType($this);
        $this->types[BooleanMetaType::class] = $this->boolean;
        $this->float = new FloatMetaType($this);
        $this->types[FloatMetaType::class] = $this->float;
        $this->int = new IntegerMetaType($this);
        $this->types[IntegerMetaType::class] = $this->int;
        $this->object = new ObjectMetaType($this);
        $this->types[ObjectMetaType::class] = $this->object;
        $this->string = new StringMetaType($this);
        $this->types[StringMetaType::class] = $this->string;
    }

    /**
     * Sets the subject to apply this meta to
     * @param HasMeta $metaSubject
     * @return $this
     */
    public function setSubject(HasMeta $metaSubject)
    {
        $this->metaSubject = $metaSubject;
        return $this;
    }

    /**
     * The programmatic name for this attribute.
     * @return string
     */
    public abstract function name(): string;


    /**
     * The human readable label for the attribute
     * @return string
     */
    public abstract function label(): string;

    /**
     * The description for this attribute
     * @return string
     */
    public abstract function description(): string;



    /**
     * The data type of the attribute. Possible values: "string", "boolean", "array"
     * @return string
     */
    public abstract function type(): string;


    /**
     * Get the possibly values that this meta attribute can have for documentation.
     * @return array
     */
    public abstract function possibleValues(): array;

    /**
     * Gets the default value of this attribute
     * @return mixed
     */
    public function default() {
        return $this->types[$this->type()]->default();
    }
    /**
     * Gets the value
     * @return mixed
     */
    public function get() {
        return $this->types[$this->type()]->get();
    }

    public function exists() : bool {
        return $this->driver->getMetaValue($this->metaSubject, $this, null) !== null;
    }

    /**
     * Sets the value
     * @param $value
     * @return bool
     */
    public function set($value) : bool {
        return $this->types[$this->type()]->set($value);
    }


    /**
     * Removes the value
     * @return boolean
     */
    public function remove()
    {
        return $this->driver->deleteMetaValue($this->metaSubject, $this->name());
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public function setRawValue($value)
    {
        return $this->driver->setMetaValue($this->metaSubject, $this->name(), $value);
    }

    /**
     * Gets a meta value
     * @return null|string
     */
    public function getRawValue()
    {
        return $this->driver->getMetaValue($this->metaSubject, $this->name(), $this->default());
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