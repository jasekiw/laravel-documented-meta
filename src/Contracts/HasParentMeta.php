<?php

namespace LaravelDocumentedMeta\Contracts;

use LaravelDocumentedMeta\Contracts\HasMeta;

/**
 * Interface HasParentMeta
 * @package LaravelDocumentedMeta
 */
interface HasParentMeta
{
    /**
     * @return HasMeta
     */
    public function getParentMetaSubject() : HasMeta;
}