<?php

namespace LaravelDocumentedMeta\Storage;

use LaravelDocumentedMeta\Attribute\MetaAttribute;
use LaravelDocumentedMeta\Contracts\HasMeta;

interface MetaProvider
{
    /**
     *
     * @param HasMeta $metaSubject
     * @param MetaAttribute $option
     * @return mixed
     */
    public function getMetaValue(HasMeta $metaSubject, MetaAttribute $option);

    /**
     *
     * @param HasMeta $metaSubject
     * @param MetaAttribute $option
     * @param $value
     * @return bool
     */
    public function setMetaValue(HasMeta $metaSubject, MetaAttribute $option, $value) : bool;

    /**
     * @param HasMeta $metaSubject
     * @param MetaAttribute $option
     * @return bool
     */
    public function deleteMetaValue(HasMeta $metaSubject, MetaAttribute $option) : bool;
}