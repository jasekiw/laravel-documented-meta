<?php

namespace LaravelDocumentedMeta\Containers;

use LaravelDocumentedMeta\Attribute\AttributeIterator;
use LaravelDocumentedMeta\Containers\MetaTypeContainer;
use LaravelDocumentedMeta\Concerns\RetrievesMeta;
use LaravelDocumentedMeta\Contracts\HasMeta;

/**
 * Class BaseKernel
 * @package App\Lib\User\Meta
 */
class MetaKernel
{

    protected $configByMetaType = [];


    /**
     * @param HasMeta|RetrievesMeta $metaSubject
     * @return MetaTypeContainer
     */
    public function getMetaConfig( HasMeta $metaSubject) {

        if(isset($this->configByMetaType[get_class($metaSubject)]))
            return $this->configByMetaType[get_class($metaSubject)];

        $this->configByMetaType[get_class($metaSubject)] =  new MetaTypeContainer($metaSubject);

        return $this->configByMetaType[get_class($metaSubject)];
    }



}