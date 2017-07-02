<?php

namespace LaravelDocumentedMeta\Contracts;

use LaravelDocumentedMeta\Attribute\MetaAttribute;


/**
 * Interface HasMeta
 * @package LaravelDocumentedMeta
 */
interface HasMeta
{
    /**
     * Get the meta attributes that are related to this model
     * @return array
     */
    public function getMetaAttributes() : array;

    /**
     * Get the name of the meta type. This has to be unique per model
     * @return string
     */
    public function getMetaTypeName() : string;

    /**
     * Get the primary key id of the model
     * @return int
     */
    public function getMetaSubjectId() : int;

    /**
     * @param string $nameOrClass
     * @return mixed
     */
    public function getMeta(string $nameOrClass);

    /**
     * Sets a meta attribute
     * @param string $nameOrClass
     * @param $value
     * @return bool
     */
    public function setMeta(string $nameOrClass, $value) : bool;

    /**
     * Check whether the given attribute has a value
     * @param string $keyOrClass
     * @return bool
     */
    public function metaExists(string $keyOrClass) : bool;

    /**
     * Get the raw meta attribute
     * @param string $keyOrClass
     * @return MetaAttribute
     */
    public function getMetaAttribute(string $keyOrClass);

    /**
     * Get the array containing the current attributes for documentation and auto setting.
     * @return array
     */
    public function getMetaConfiguration() : array;

}