<?php

namespace LaravelDocumentedMeta;

interface HasParentMeta
{
    public function getParentMetaSubject() : MetaSubject;
}