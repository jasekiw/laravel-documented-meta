<?php

namespace LaravelDocumentedMeta;

/**
 * Trait MetaSubject
 * @package LaravelDocumentedMeta
 */
trait MetaSubject
{

    /**
     * @param $keyOrClass
     * @return mixed
     */
    public function getMetaValue($keyOrClass) {
       /** @var MetaKernel  $kernel */
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