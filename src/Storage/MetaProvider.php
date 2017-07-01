<?php

namespace LaravelDocumentedMeta\Storage;


use LaravelDocumentedMeta\Contracts\HasMeta;

interface MetaProvider
{
    /**
     *
     * @param HasMeta $subject
     * @param string $attributeName
     * @param null $default
     * @return mixed
     */
    public function getMetaValue(HasMeta $subject, string $attributeName, $default = null) ;

    /**
     *
     * @param HasMeta $subject
     * @param string $attributeName
     * @param $value
     * @return bool
     */
    public function setMetaValue(HasMeta $subject, string $attributeName, $value) : bool;

    /**
     * @param HasMeta $subject
     * @param string $attributeName
     * @return bool
     * @internal param int $subjectId
     * @internal param string $subjectType
     */
    public function deleteMetaValue(HasMeta $subject,string $attributeName) : bool;
}