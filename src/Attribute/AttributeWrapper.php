<?php

namespace LaravelDocumentedMeta\Attribute;

use LaravelDocumentedMeta\Contracts\HasMeta;
use LaravelDocumentedMeta\Attribute\MetaAttribute;

/**
 * Class AttributeContainer
 * @package LaravelDocumentedMeta\Attribute
 */
class AttributeWrapper
{
    protected $nameSpace;
    protected $option;

    /**
     * AttributeContainer constructor.
     * @param string $namespace
     * @param MetaAttribute $option
     */
    public function __construct(string $namespace = '', MetaAttribute $option)
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
     * @return MetaAttribute
     */
    public function getAttribute()
    {
        return $this->option;
    }

    /**
     * Get the instance as an array.
     *
     * @param \LaravelDocumentedMeta\Contracts\HasMeta $subject
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