<?php

namespace LaravelDocumentedMeta;



use LaravelDocumentedMeta\AttributeParsing\AttributeIterator;
use LaravelDocumentedMeta\AttributeParsing\Config;



/**
 * Class BaseKernel
 * @package App\Lib\User\Meta
 */
abstract class Kernel
{


    /**
     * The attributes that will be registered with the kernel
     * @return mixed
     */
    protected abstract function attributes(): array;

    /**
     * @var MetaOption[]
     */
    private $registeredAttributesByName = [];

    /**
     * @var MetaOption[]
     */
    private $registeredAttributesByClassName = [];

    /**
     * @var Config
     */
    private $namespacedAttributes;

    /**
     * Kernel constructor.
     *
     */
    function __construct()
    {
        $this->initializeAttributes();
    }

    protected function initializeAttributes()
    {
        $this->namespacedAttributes = new Config(
            (new AttributeIterator())->parse($this->attributes(), function($namespace, $class) {
            /** @var MetaOption $attribute */
            $attribute = new $class($this->user, $namespace);
            $this->registeredAttributesByName[$attribute->getName()] = $attribute;
            $this->registeredAttributesByClassName[get_class($attribute)] = $attribute;
            return $attribute;
        }));

    }


    /**
     * Get attribute by class name
     * @param string $className The name of the class. ex Dog::class
     * @param MetaSubject $subject
     * @return MetaOption|null
     */
    public function getAttributeByClass(string $className, MetaSubject $subject)
    {
        if (isset($this->registeredAttributesByClassName[$className]))
            return $this->registeredAttributesByClassName[$className];
        return null;
    }

    /**
     * Gets an attribute by it's programmatic name
     * @param string $name
     * @param MetaSubject $subject
     * @return MetaOption|null
     */
    public function getAttributeByName(string $name, MetaSubject $subject)
    {
        if (isset($this->registeredAttributesByName[$name]))
            return $this->registeredAttributesByName[$name];
        return null;
    }

    /**
     * Gets all of the meta options for the user
     * and their descriptions
     * @param MetaSubject $subject
     * @return array
     */
    public function getAllMetaConfig(MetaSubject $subject)
    {
        $attributes = [];
        foreach ($this->registeredAttributesByName as $metaKey => $instance)
            array_push($attributes, $instance->toArray());
        return [
            'nested' => $this->namespacedAttributes->toArray(),
            'flat' => $attributes
        ];
    }
}