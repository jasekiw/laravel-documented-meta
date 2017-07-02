<?php

namespace LaravelDocumentedMeta\Concerns;

use LaravelDocumentedMeta\Attribute\MetaAttribute;
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
     * Get the value of the given attribute.
     *
     * Ex.  getMeta(SomeAttribute::class);
     *
     * @param string $keyOrClass The name of the attribute or the class name of the attribute.
     * @return mixed The value will be casted to the correct type upon receiving
     */
    public function getMeta(string $keyOrClass) {
       return app()->make(MetaKernel::class)->getMetaConfig($this)->getMetaValue($keyOrClass, $this);
    }

    /**
     * Saves the given meta data to the attribute.
     *
     * Ex.  setMeta(SomeAttribute::class, $value);
     *
     * @param string $keyOrClass The name of the attribute or the class name of the attribute.
     *
     * @param mixed $value
     * @return bool
     */
    public function setMeta(string $keyOrClass, $value) : bool {
        return  app()->make(MetaKernel::class)->getMetaConfig($this)->setMetaValue($keyOrClass, $this, $value);
    }

    /**
     * Check whether the given attribute has a value
     * @param string $keyOrClass
     * @return bool
     */
    public function metaExists(string $keyOrClass) : bool {
        return  app()->make(MetaKernel::class)->getMetaConfig($this)->metaExists($keyOrClass, $this);
    }

    /**
     * Get the raw meta attribute
     * @param string $keyOrClass
     * @return MetaAttribute
     */
    public function getMetaAttribute(string $keyOrClass) {
        return  app()->make(MetaKernel::class)->getMetaConfig($this)->getMetaAttribute($keyOrClass, $this);
    }

    /**
     * Get the array containing the current attributes for documentation and auto setting.
     * @return array
     */
    public function getMetaConfiguration() : array {
        return  app()->make(MetaKernel::class)->getMetaConfig($this)->getAllMetaConfig($this);
    }


}