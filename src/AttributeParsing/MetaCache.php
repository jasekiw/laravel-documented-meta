<?php


namespace LaravelDocumentedMeta\AttributeParsing;

use LaravelDocumentedMeta\Attribute\AttributeContainer;
use LaravelDocumentedMeta\HasMeta;
use LaravelDocumentedMeta\MetaAttribute;
use LaravelDocumentedMeta\MetaSubject;
use LaravelDocumentedMeta\Tests\Unit\MetaSubjectFixture;

/**
 * Class MetaCache
 * @package App\Lib\User\Meta\AttributeParsing
 */
class MetaCache
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
     * MetaCache constructor.
     * @param HasMeta|MetaSubject $metaSubject
     * @internal param MetaSubject $metSubject
     * @internal param array $configArray
     */
    public function __construct(HasMeta $metaSubject)
    {
        $this->configArray = $metaSubject->getAttributes();
        $this->configArray = (new AttributeIterator())->parse($metaSubject->getAttributes(), function($parentNamespace, $class) {
            /** @var MetaAttribute $attribute */
            app()->singleton($class);
            $attribute = app()->make($class);
            $attContainer = new AttributeContainer($parentNamespace, $attribute);
            $this->registeredAttributesByName[$attContainer->getName()] = $attContainer;
            $this->registeredAttributesByClassName[get_class($attribute)] = $attContainer;
            return $attContainer;
        });
    }

    /**
     * @param HasMeta $subject
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
     * @param HasMeta $subject
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