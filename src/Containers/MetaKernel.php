<?php

namespace LaravelDocumentedMeta\Containers;

use LaravelDocumentedMeta\Attribute\AttributeIterator;
use LaravelDocumentedMeta\Containers\MetaSubjectContainer;
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
     * @return MetaSubjectContainer
     */
    public function getMetaConfig(HasMeta $metaSubject) : MetaSubjectContainer {

        if(isset($this->configByMetaType[get_class($metaSubject)]))
            return $this->configByMetaType[get_class($metaSubject)];

        $this->configByMetaType[get_class($metaSubject)] =  new MetaSubjectContainer($metaSubject, app()->make(AttributeContainer::class));

        return $this->configByMetaType[get_class($metaSubject)];
    }



}