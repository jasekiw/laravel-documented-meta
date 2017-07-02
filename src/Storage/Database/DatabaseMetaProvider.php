<?php

namespace LaravelDocumentedMeta\Storage\Database;

use LaravelDocumentedMeta\Contracts\HasMeta;
use LaravelDocumentedMeta\Contracts\HasParentMeta;
use LaravelDocumentedMeta\Attribute\MetaAttribute;
use LaravelDocumentedMeta\Storage\MetaProvider;

/**
 * Class MetaDriver
 * @package LaravelDocumentedMeta\Storage\Database
 */
class DatabaseMetaProvider implements MetaProvider
{
    /**
     * @param HasMeta $metaSubject
     * @param string $attributeName
     * @param mixed $default
     * @return mixed
     * @internal param MetaAttribute $option
     */
    public function getMetaValue(HasMeta $metaSubject, string $attributeName, $default = null) {
        $meta = Meta::query()->where('key', '=', $attributeName)
                ->where('subject_id','=', $metaSubject->getMetaSubjectId())
                ->where('type', '=', $metaSubject->getMetaTypeName())->first();
        if(isset($meta))
            return $meta->value;

        if(!$metaSubject instanceof HasParentMeta)
            return $default;

        return $this->getMetaValue($metaSubject->getParentMetaSubject(), $attributeName, $default);
    }

    /**
     * @param HasMeta $metaSubject
     * @param string $attributeName
     * @param $value
     * @return bool
     * @internal param MetaAttribute $option
     */
    public function setMetaValue(HasMeta $metaSubject, string $attributeName,  $value) : bool {
        $meta = Meta::query()->where('key', '=', $attributeName)
            ->where('subject_id','=', $metaSubject->getMetaSubjectId())
            ->where('type', '=', $metaSubject->getMetaTypeName())->first();
        if(!isset($meta))
            $meta = new Meta([
                'subject_id' => $metaSubject->getMetaSubjectId(),
                'type' => $metaSubject->getMetaTypeName(),
                'key' => $attributeName
            ]);
        $meta->value = $value;
        return $meta->save();
    }

    /**
     * @param HasMeta $metaSubject
     * @param string $attributeName
     * @return bool
     * @internal param MetaAttribute $option
     */
    public function deleteMetaValue(HasMeta $metaSubject, string $attributeName) : bool {
        /** @var Meta $meta */
        $meta = Meta::query()->where('key', '=', $attributeName)
            ->where('subject_id','=', $metaSubject->getMetaSubjectId())
            ->where('type', '=', $metaSubject->getMetaTypeName())->first();
        if(isset($meta))
            return $meta->delete();
        return false;
    }

}