<?php

namespace LaravelDocumentedMeta\Storage;

use LaravelDocumentedMeta\Contracts\HasMeta;
use LaravelDocumentedMeta\Contracts\HasParentMeta;

class ArrayMetaProvider implements MetaProvider
{

    protected $attributesStorage;

    /**
     *
     * @param HasMeta $subject
     * @param string $attributeName
     * @param null $default
     * @return mixed
     */
    public function getMetaValue(HasMeta $subject, string $attributeName, $default = null)
    {
        if ($this->hasAttribute($attributeName, $subject->getMetaSubjectId(), $subject->getMetaTypeName()))
            return $this->attributesStorage[$subject->getMetaTypeName()][$attributeName][$subject->getMetaSubjectId()];

        if (!$subject instanceof HasParentMeta)
            return $default;

        return $this->getMetaValue($subject->getParentMetaSubject(), $attributeName, $default);
    }

    /**
     *
     * @param HasMeta $subject
     * @param string $attributeName
     * @param $value
     * @return bool
     */
    public function setMetaValue(HasMeta $subject, string $attributeName, $value): bool
    {
        if ($this->hasAttribute($attributeName, $subject->getMetaSubjectId(), $subject->getMetaTypeName())) {
            $this->attributesStorage[$subject->getMetaTypeName()][$attributeName][$subject->getMetaSubjectId()] = (string)$value;
            return true;
        }
        $typeName = $subject->getMetaTypeName();
        $id = $subject->getMetaSubjectId();
        if (!isset($this->attributesStorage[$typeName]))
            $this->attributesStorage[$typeName] = [];
        if (!isset($this->attributesStorage[$typeName][$attributeName]))
            $this->attributesStorage[$typeName][$attributeName] = [];
        if (!isset($this->attributesStorage[$typeName][$attributeName][$id]))
            $this->attributesStorage[$typeName][$attributeName][$id] = (string)$value;
        return true;
    }

    /**
     * @param string $attributeName
     * @param int $subjectId
     * @param string $metaType
     * @return bool
     * @internal param string $optionName
     */
    private function hasAttribute(string $attributeName, int $subjectId, string $metaType)
    {
        return isset($this->attributesStorage[$metaType]) &&
            isset($this->attributesStorage[$metaType][$attributeName]) &&
            isset($this->attributesStorage[$metaType][$attributeName][$subjectId]);
    }

    /**
     * @param HasMeta $subject
     * @param string $attributeName
     * @return bool
     */
    public function deleteMetaValue(HasMeta $subject, string $attributeName): bool
    {
        if ($this->hasAttribute($attributeName, $subject->getMetaSubjectId(), $subject->getMetaTypeName()))
            unset($this->attributesStorage[$subject->getMetaTypeName()][$attributeName][$subject->getMetaSubjectId()]);
        return true;
    }
}