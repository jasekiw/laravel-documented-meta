<?php

namespace LaravelDocumentedMeta;

use LaravelDocumentedMeta\AttributeParsing\AttributeIterator;
use LaravelDocumentedMeta\AttributeParsing\MetaCache;

/**
 * Class BaseKernel
 * @package App\Lib\User\Meta
 */
class MetaKernel
{

    protected $configByMetaType = [];


    /**
     * @param HasMeta|MetaSubject $metaSubject
     * @return MetaCache
     */
    public function getMetaConfig( HasMeta $metaSubject) {

        if(isset($this->configByMetaType[get_class($metaSubject)]))
            return $this->configByMetaType[get_class($metaSubject)];

        $this->configByMetaType[get_class($metaSubject)] =  new MetaCache($metaSubject);

        return $this->configByMetaType[get_class($metaSubject)];
    }



}