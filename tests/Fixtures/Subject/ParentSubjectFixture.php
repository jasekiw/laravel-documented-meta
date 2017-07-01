<?php

namespace LaravelDocumentedMeta\Tests\Fixtures\Subject;

use LaravelDocumentedMeta\Concerns\RetrievesMeta;
use LaravelDocumentedMeta\Contracts\HasMeta;
use LaravelDocumentedMeta\Tests\Fixtures\MetaAttributeFixture;

class ParentSubjectFixture implements HasMeta
{
    use RetrievesMeta;

    /**
     * Get the meta attributes that are related to this model
     * @return array
     */
    public function getMetaAttributes(): array
    {
        return [
            'namespace' => MetaAttributeFixture::class
        ];
    }

    /**
     * Get the name of the meta type. This has to be unique per model
     * @return string
     */
    public function getMetaTypeName(): string
    {
        return 'parent-subject';
    }

    /**
     * Get the primary key id of the model
     * @return int
     */
    public function getMetaSubjectId() : int
    {
        return 1;
    }
}