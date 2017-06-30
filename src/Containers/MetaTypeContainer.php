<?php


namespace LaravelDocumentedMeta\Containers;

use LaravelDocumentedMeta\Attribute\AttributeContainer;
use LaravelDocumentedMeta\Attribute\AttributeIterator;
use LaravelDocumentedMeta\Contracts\HasMeta;
use LaravelDocumentedMeta\Concerns\RetrievesMeta;

/**
 * Class MetaTypeContainer
 * @package App\Lib\User\Meta\AttributeParsing
 */
class MetaTypeContainer
{
    /**
     * @var AttributeContainer[]
     */
    private $registeredAttributesByName = [];

    /**
     * @var AttributeContainer[]
     */
    private $registeredAttributesByClassName = [];

    /**
     * @var array
     */
    protected $configArray;

    /**
     * MetaTypeContainer constructor.
     * @param \LaravelDocumentedMeta\Contracts\HasMeta|RetrievesMeta $metaSubject
     * @internal param RetrievesMeta $metSubject
     * @internal param array $configArray
     */
    public function __construct(HasMeta $metaSubject)
    {
        $this->configArray = $metaSubject->getAttributes();
        $this->configArray = (new AttributeIterator())->parse($metaSubject->getAttributes(), function($parentNamespace, $class) {
            /** @var \LaravelDocumentedMeta\Attribute\MetaAttribute $attribute */
            app()->singleton($class);
            $attribute = app()->make($class);
            $attContainer = new AttributeContainer($parentNamespace, $attribute);
            $this->registeredAttributesByName[$attContainer->getName()] = $attContainer;
            $this->registeredAttributesByClassName[get_class($attribute)] = $attContainer;
            return $attContainer;
        });
    }

    /**
     * @param \LaravelDocumentedMeta\Contracts\HasMeta $subject
     * @return array
     */
    public function getNameSpacedConfig(HasMeta $subject) {

       return (new AttributeIterator())->parse($this->configArray, function ($namespace, AttributeContainer &$object) use($subject) {
            return $object->toArray($subject, false);
        });

    }

    /**
     * Get attribute by class name
     * @param string $className The name of the class. ex Dog::class
     * @return AttributeContainer
     */
    public function getAttributeByClass(string $className)
    {
        if (isset($this->registeredAttributesByClassName[$className]))
            return $this->registeredAttributesByClassName[$className];
        return null;
    }

    /**
     * @param string $keyOrClass
     * @param HasMeta $subject
     * @return mixed
     */
    public function getMetaValue(string $keyOrClass, HasMeta $subject) {
        if(class_exists($keyOrClass))
            return $this->getAttributeByClass($keyOrClass)->getAttribute()->setSubject($subject)->get();
        else
            return $this->getAttributeByName($keyOrClass)->getAttribute()->setSubject($subject)->get();
    }


    /**
     * @param $keyOrClass
     * @param HasMeta $subject
     * @param $value
     * @return bool
     */
    public function setMetaValue($keyOrClass, HasMeta $subject, $value) {
        if(class_exists($keyOrClass))
            return $this->getAttributeByClass($keyOrClass)->getAttribute()->setSubject($subject)->set($value);
        else
            return $this->getAttributeByName($keyOrClass)->getAttribute()->setSubject($subject)->set($value);
    }


    /**
     * Gets an attribute by it's programmatic name
     * @param string $name
     * @return AttributeContainer|null
     */
    public function getAttributeByName(string $name)
    {
        if (isset($this->registeredAttributesByName[$name]))
            return $this->registeredAttributesByName[$name];
        return null;
    }

    /**
     * Gets all of the meta options for the user
     * and their descriptions
     * @param \LaravelDocumentedMeta\Contracts\HasMeta $subject
     * @return array
     */
    public function getAllMetaConfig(HasMeta $subject)
    {
        $attributes = [];
        foreach ($this->registeredAttributesByName as $metaKey => $instance)
            array_push($attributes, $instance->toArray($subject));
        return [
            'nested' => $this->getNameSpacedConfig($subject),
            'flat' => $attributes
        ];
    }
}