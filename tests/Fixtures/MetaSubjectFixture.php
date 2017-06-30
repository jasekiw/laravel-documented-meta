<?php

namespace LaravelDocumentedMeta\Tests\Fixtures;


use LaravelDocumentedMeta\HasMeta;
use LaravelDocumentedMeta\MetaSubject;

/**
 * Class MetaSubjectFixture
 * @package LaravelDocumentedMeta\Tests\Unit
 */
class MetaSubjectFixture implements HasMeta
{
    use MetaSubject;

    /**
     * Get the meta attributes that are related to this model
     * @return array
     */
    public function getAttributes(): array
    {
        return [

        ];
    }

    /**
     * Get the name of the meta type. This has to be unique per model
     * @return string
     */
    public function getMetaTypeName(): string
    {
        return 'test-name';
    }

    /**
     * Get the primary key id of the model
     * @return int
     */
    public function getMetaSubjectId()
    {
        return 1;
    }
}