<?php

namespace LaravelDocumentedMeta\Concerns;

use LaravelDocumentedMeta\Containers\MetaKernel;
use LaravelDocumentedMeta\Contracts\HasMeta;

/**
 * Trait RetrievesMeta
 * @package LaravelDocumentedMeta
 * @mixin HasMeta
 */
trait RetrievesMeta
{

    /**
     * @param $keyOrClass
     * @return mixed
     */
    public function getMetaValue($keyOrClass) {
       return  app()->make(MetaKernel::class)->getMetaConfig($this)->getMetaValue($keyOrClass, $this);
    }

    /**
     * @param $keyOrClass
     * @param $value
     * @return bool
     */
    public function setMetaValue($keyOrClass, $value) {
        return  app()->make(MetaKernel::class)->getMetaConfig($this)->setMetaValue($keyOrClass, $this, $value);
    }


}