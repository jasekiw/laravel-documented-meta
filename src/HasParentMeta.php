<?php

namespace LaravelDocumentedMeta;

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