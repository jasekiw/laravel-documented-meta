<?php

namespace LaravelDocumentedMeta\Database;


use LaravelDocumentedMeta\Contracts\HasMeta;
use LaravelDocumentedMeta\Contracts\HasParentMeta;
use LaravelDocumentedMeta\Attribute\MetaAttribute;

class MetaDriver
{
    /**
     * @param HasMeta $metaSubject
     * @param \LaravelDocumentedMeta\Attribute\MetaAttribute $option
     * @return mixed
     */
    public function getMetaValue(HasMeta $metaSubject, MetaAttribute $option) {
        $meta = Meta::query()->where('key', '=', $option->name())
                ->where('subject_id','=', $metaSubject->getMetaSubjectId())
                ->where('type', '=', $metaSubject->getMetaTypeName())->first();
        if(isset($meta))
            return $meta->value;

        if(!$metaSubject instanceof HasParentMeta)
            return $option->default();

        return $this->getMetaValue($metaSubject->getParentMetaSubject(), $option);
    }

    /**
     * @param HasMeta $metaSubject
     * @param MetaAttribute $option
     * @param $value
     * @return bool
     */
    public function setMetaValue(HasMeta $metaSubject, MetaAttribute $option, $value) {
        $meta = Meta::query()->where('key', '=', $option->name())
            ->where('subject_id','=', $metaSubject->getMetaSubjectId())
            ->where('type', '=', $metaSubject->getMetaTypeName())->first();
        if(!isset($meta))
            $meta = new Meta([
                'subject_id' => $metaSubject->getMetaSubjectId(),
                'type' => $metaSubject->getMetaTypeName(),
                'key' => $option->name()
            ]);
        $meta->value = $value;
        return $meta->save();
    }

    /**
     * @param HasMeta $metaSubject
     * @param MetaAttribute $option
     * @return bool
     */
    public function deleteMetaValue(HasMeta $metaSubject, MetaAttribute $option) {
        /** @var Meta $meta */
        $meta = Meta::query()->where('key', '=', $option->name())
            ->where('subject_id','=', $metaSubject->getMetaSubjectId())
            ->where('type', '=', $metaSubject->getMetaTypeName())->first();
        if(isset($meta))
            return $meta->delete();
        return false;
    }

}