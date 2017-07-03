<?php

namespace LaravelDocumentedMeta\Tests\Fixtures\Subject;


use LaravelDocumentedMeta\Concerns\RetrievesMeta;
use LaravelDocumentedMeta\Contracts\HasMeta;
use LaravelDocumentedMeta\Tests\Fixtures\MetaAttribute\StringAttributeFixture;

/**
 * Class MetaSubjectFixture
 * @package LaravelDocumentedMeta\Tests\Unit
 */
class DifferentSubjectFixture implements HasMeta
{
    use RetrievesMeta;

    /**
     * Get the meta attributes that are related to this model
     * @return array
     */
    public function getMetaAttributes(): array
    {
        return [
            'namespace' => [
                StringAttributeFixture::class
            ]
        ];
    }

    /**
     * Get the name of the meta type. This has to be unique per model
     * @return string
     */
    public function getMetaTypeName(): string
    {
        return 'different-subject';
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