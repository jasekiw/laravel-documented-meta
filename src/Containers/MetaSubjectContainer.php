<?php


namespace LaravelDocumentedMeta\Containers;

use LaravelDocumentedMeta\Attribute\AttributeWrapper;
use LaravelDocumentedMeta\Attribute\AttributeIterator;
use LaravelDocumentedMeta\Contracts\HasMeta;
use LaravelDocumentedMeta\Concerns\RetrievesMeta;

/**
 * Class MetaTypeContainer
 * @package App\Lib\User\Meta\AttributeParsing
 */
class MetaSubjectContainer
{
    /**
     * @var AttributeWrapper[]
     */
    private $registeredAttributesByName = [];

    /**
     * @var AttributeWrapper[]
     */
    private $registeredAttributesByClassName = [];

    /**
     * @var array
     */
    protected $configArray;

    /**
     * @var AttributeContainer
     */
    protected $container;
    /**
     * MetaTypeContainer constructor.
     * @param \LaravelDocumentedMeta\Contracts\HasMeta|RetrievesMeta $metaSubject
     * @param AttributeContainer $container
     * @internal param RetrievesMeta $metSubject
     * @internal param array $configArray
     */
    public function __construct(HasMeta $metaSubject, AttributeContainer $container)
    {
        $this->container = $container;
        $this->configArray = $metaSubject->getMetaAttributes();
        $this->configArray = (new AttributeIterator())->parse($metaSubject->getMetaAttributes(), function($namespace, $class) {
            $attContainer = new AttributeWrapper($namespace, $this->container->register($class));
            $this->registeredAttributesByName[$attContainer->getName()] = $attContainer;
            $this->registeredAttributesByClassName[get_class($attContainer->getAttribute())] = $attContainer;
            return $attContainer;
        });
    }

    /**
     * @param \LaravelDocumentedMeta\Contracts\HasMeta $subject
     * @return array
     */
    public function getNameSpacedConfig(HasMeta $subject) {

       return (new AttributeIterator())->parse($this->configArray, function ($namespace, AttributeWrapper &$object) use($subject) {
            return $object->toArray($subject, false);
        });

    }

    /**
     * Get attribute by class name
     * @param string $className The name of the class. ex Dog::class
     * @return AttributeWrapper
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
     * @param string $keyOrClass
     * @param HasMeta $subject
     * @return bool
     */
    public function metaExists(string $keyOrClass, HasMeta $subject) : bool {
        if(class_exists($keyOrClass))
            return $this->getAttributeByClass($keyOrClass)->getAttribute()->setSubject($subject)->exists();
        else
            return $this->getAttributeByName($keyOrClass)->getAttribute()->setSubject($subject)->exists();
    }


    /**
     * Gets an attribute by it's programmatic name
     * @param string $name
     * @return AttributeWrapper|null
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