<?php

namespace LaravelDocumentedMeta;

trait MetaSubject
{
   public abstract function getAttributes() : array;

    /**
     * @param $keyOrClass
     */
   public function getMetaValue($keyOrClass) {
       $kernel = app()->make(Kernel::class);

   }
}