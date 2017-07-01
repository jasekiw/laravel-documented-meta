<?php

namespace LaravelDocumentedMeta\Storage;

use LaravelDocumentedMeta\Attribute\MetaAttribute;
use LaravelDocumentedMeta\Contracts\HasMeta;
use LaravelDocumentedMeta\Contracts\HasParentMeta;

class ArrayMetaProvider implements MetaProvider
{

    protected $attributesStorage;

    /**
     *
     * @param HasMeta $metaSubject
     * @param MetaAttribute $option
     * @return mixed
     */
    public function getMetaValue(HasMeta $metaSubject, MetaAttribute $option)
    {
        if ($this->hasAttribute($metaSubject, $option->name()))
            return $this->attributesStorage[$metaSubject->getMetaTypeName()][$option->name()][$metaSubject->getMetaSubjectId()];

        if (!$metaSubject instanceof HasParentMeta)
            return $option->default();

        return $this->getMetaValue($metaSubject->getParentMetaSubject(), $option);
    }

    /**
     *
     * @param HasMeta $metaSubject
     * @param MetaAttribute $option
     * @param $value
     * @return bool
     */
    public function setMetaValue(HasMeta $metaSubject, MetaAttribute $option, $value): bool
    {
        if ($this->hasAttribute($metaSubject, $option->name())) {
            $this->attributesStorage[$metaSubject->getMetaTypeName()][$option->name()][$metaSubject->getMetaSubjectId()] = (string)$value;
            return true;
        }
        $typeName = $metaSubject->getMetaTypeName();
        $attName = $option->name();
        $id = $metaSubject->getMetaSubjectId();
        if (!isset($this->attributesStorage[$typeName]))
            $this->attributesStorage[$typeName] = [];
        if (!isset($this->attributesStorage[$typeName][$attName]))
            $this->attributesStorage[$typeName][$attName] = [];
        if (!isset($this->attributesStorage[$typeName][$attName][$id]))
            $this->attributesStorage[$typeName][$attName][$id] = (string)$value;
        return true;
    }

    /**
     * @param HasMeta $metaSubject
     * @param string $optionName
     * @return bool
     */
    private function hasAttribute(HasMeta $metaSubject, string $optionName)
    {
        return isset($this->attributesStorage[$metaSubject->getMetaTypeName()]) &&
            isset($this->attributesStorage[$metaSubject->getMetaTypeName()][$optionName]) &&
            isset($this->attributesStorage[$metaSubject->getMetaTypeName()][$optionName][$metaSubject->getMetaSubjectId()]);
    }

    /**
     * @param HasMeta $metaSubject
     * @param MetaAttribute $option
     * @return bool
     */
    public function deleteMetaValue(HasMeta $metaSubject, MetaAttribute $option): bool
    {
        if ($this->hasAttribute($metaSubject, $option->name()))
            unset($this->attributesStorage[$metaSubject->getMetaTypeName()][$option->name()][$metaSubject->getMetaSubjectId()]);
        return true;
    }
}