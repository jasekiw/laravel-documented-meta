<?php

namespace LaravelDocumentedMeta\Storage;

use LaravelDocumentedMeta\Attribute\MetaAttribute;
use LaravelDocumentedMeta\Contracts\HasMeta;

class ArrayMetaProvider implements MetaProvider
{



    /**
     *
     * @param HasMeta $metaSubject
     * @param MetaAttribute $option
     * @return mixed
     */
    public function getMetaValue(HasMeta $metaSubject, MetaAttribute $option)
    {
        // TODO: Implement getMetaValue() method.
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
        // TODO: Implement setMetaValue() method.
    }
}