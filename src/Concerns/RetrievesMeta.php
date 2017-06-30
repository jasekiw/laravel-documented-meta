<?php

namespace LaravelDocumentedMeta\Concerns;

use LaravelDocumentedMeta\Containers\MetaKernel;

/**
 * Trait RetrievesMeta
 * @package LaravelDocumentedMeta
 */
trait RetrievesMeta
{

    /**
     * @param $keyOrClass
     * @return mixed
     */
    public function getMetaValue($keyOrClass) {
       /** @var \LaravelDocumentedMeta\Containers\MetaKernel  $kernel */
       $kernel = app()->make(MetaKernel::class);
       return $kernel->getMetaConfig($this)->getAttributeByClass($keyOrClass, $this)->get();
    }

    /**
     * @param $keyOrClass
     * @param $value
     * @return bool
     */
    public function setMetaValue($keyOrClass, $value) {
        /** @var MetaKernel  $kernel */
        $kernel = app()->make(MetaKernel::class);
        return $kernel->getMetaConfig($this)->getAttributeByClass($keyOrClass, $this)->set($value);
    }


}