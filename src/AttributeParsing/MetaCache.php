<?php


namespace LaravelDocumentedMeta\AttributeParsing;


use Illuminate\Contracts\Support\Arrayable;
use LaravelDocumentedMeta\Attribute\AttributeContainer;
use LaravelDocumentedMeta\HasMeta;
use LaravelDocumentedMeta\MetaOption;
use LaravelDocumentedMeta\MetaSubject;

/**
 * Class MetaCache
 * @package App\Lib\User\Meta\AttributeParsing
 */
class MetaCache implements Arrayable
{
    /**
     * @var MetaOption[]
     */
    private $registeredAttributesByName = [];

    /**
     * @var MetaOption[]
     */
    private $registeredAttributesByClassName = [];

    /**
     * @var MetaCache
     */
    private $nameSpacedAttributes;


    /**
     * @var array
     */
    protected $configArray;

    /**
     * MetaCache constructor.
     * @param HasMeta|MetaSubject $metaSubject
     * @internal param MetaSubject $metSubject
     * @internal param array $configArray
     */
    public function __construct(HasMeta $metaSubject)
    {
        $this->configArray = $metaSubject->getAttributes();
        (new AttributeIterator())->parse($metaSubject->getAttributes(), function($parentNamespace, $class) {
            /** @var MetaOption $attribute */
            app()->singleton($class);
            $attribute = app()->make($class);
            $attContainer = new AttributeContainer($parentNamespace, $class);
            $this->registeredAttributesByName[$attContainer->getName()] = $attContainer;
            $this->registeredAttributesByClassName[get_class($attribute)] = $attContainer;
            return $attContainer;
        });
    }


    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return (new AttributeIterator())->parse($this->configArray, function ($namespace, $object) {
            /** @var Arrayable $object*/
            return $object->toArray();
        });

    }


    /**
     * Get attribute by class name
     * @param string $className The name of the class. ex Dog::class
     * @param HasMeta|MetaSubject $subject
     * @return MetaOption|null
     */
    public function getAttributeByClass(string $className, HasMeta $subject)
    {
        if (isset($this->registeredAttributesByClassName[$className]))
            return $this->registeredAttributesByClassName[$className];
        return null;
    }

    /**
     * Gets an attribute by it's programmatic name
     * @param string $name
     * @param HasMeta|MetaSubject $subject
     * @return MetaOption|null
     */
    public function getAttributeByName(string $name, HasMeta $subject)
    {
        if (isset($this->registeredAttributesByName[$name]))
            return $this->registeredAttributesByName[$name];
        return null;
    }

    /**
     * Gets all of the meta options for the user
     * and their descriptions
     * @param HasMeta|MetaSubject $subject
     * @return array
     */
    public function getAllMetaConfig(HasMeta $subject)
    {
        $attributes = [];
        foreach ($this->registeredAttributesByName as $metaKey => $instance)
            array_push($attributes, $instance->toArray());
        return [
            'nested' => $this->nameSpacedAttributes->toArray(),
            'flat' => $attributes
        ];
    }
}