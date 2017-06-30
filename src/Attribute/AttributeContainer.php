<?php

namespace LaravelDocumentedMeta\Attribute;

use LaravelDocumentedMeta\HasMeta;
use LaravelDocumentedMeta\MetaOption;

/**
 * Class AttributeContainer
 * @package LaravelDocumentedMeta\Attribute
 */
class AttributeContainer
{
    protected $nameSpace;
    protected $option;

    /**
     * AttributeContainer constructor.
     * @param string $namespace
     * @param MetaOption $option
     */
    public function __construct(string $namespace = '', MetaOption $option)
    {
        $this->nameSpace = $namespace;
        $this->option = $option;
    }

    /**
     * Gets the Attribute Name
     * @return string
     */
    public function getName()
    {
        return ($this->nameSpace == "" ? "" : $this->nameSpace . ".") . $this->option->name();
    }

    /**
     * @return MetaOption
     */
    public function getAttribute()
    {
        return $this->option;
    }

    /**
     * Get the instance as an array.
     *
     * @param HasMeta $subject
     * @param bool $includePrefix
     * @return array
     */
    public function toArray(HasMeta $subject, $includePrefix = true)
    {
        $this->option->setSubject($subject);
        $name = $includePrefix ? $this->getName() : $this->option->name();
        return [
            'name' => $name,
            'label' => $this->option->label(),
            'description' => $this->option->description(),
            'type' => $this->option->type(),
            'value' => $this->option->get(),
            'default' => $this->option->default()
        ];
    }
}