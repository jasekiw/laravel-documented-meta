<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 6/30/2017
 * Time: 11:38 AM
 */

namespace LaravelDocumentedMeta;


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
    public function getAttributes() : array;

    /**
     * Get the name of the meta type. This has to be unique per model
     * @return string
     */
    public function getMetaTypeName() : string;

    /**
     * Get the primary key id of the model
     * @return int
     */
    public function getMetaSubjectId();

}