<?php


namespace LaravelDocumentedMeta\Containers;

use LaravelDocumentedMeta\Attribute\AttributeWrapper;
use LaravelDocumentedMeta\Attribute\AttributeIterator;
use LaravelDocumentedMeta\Attribute\MetaAttribute;
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
    public function getWrapperByClass(string $className)
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
        $wrapper = $this->getWrapper($keyOrClass);
        if($wrapper == null)
            return null;
        return $wrapper->getAttribute()->setSubject($subject)->get();
    }


    /**
     * @param $keyOrClass
     * @param HasMeta $subject
     * @param $value
     * @return bool
     */
    public function setMetaValue($keyOrClass, HasMeta $subject, $value) : bool {
        $wrapper = $this->getWrapper($keyOrClass);
        if($wrapper == null)
            return false;
        return $wrapper->getAttribute()->setSubject($subject)->set($value);
    }

    /**
     * @param string $keyOrClass
     * @param HasMeta $subject
     * @return bool
     */
    public function metaExists(string $keyOrClass, HasMeta $subject) : bool {
        $wrapper = $this->getWrapper($keyOrClass);
        if($wrapper == null)
            return false;
        return $wrapper->getAttribute()->setSubject($subject)->exists();
    }

    /**
     * Gets the wrapper for an attribute
     * @param string $keyOrClass
     * @return AttributeWrapper|null
     */
    protected function getWrapper(string $keyOrClass) {
        if(class_exists($keyOrClass))
            $wrapper = $this->getWrapperByClass($keyOrClass);
        else
            $wrapper = $this->getWrapperByName($keyOrClass);
        return $wrapper;
    }

    /**
     * @param string $keyOrClass
     * @param HasMeta $subject
     * @return MetaAttribute
     */
    public function getMetaAttribute(string $keyOrClass, HasMeta $subject) {
        $wrapper = $this->getWrapper($keyOrClass);
        if($wrapper == null)
            return null;
        return $wrapper->getAttribute()->setSubject($subject);
    }


    /**
     * Gets an attribute by it's programmatic name
     * @param string $name
     * @return AttributeWrapper|null
     */
    public function getWrapperByName(string $name)
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