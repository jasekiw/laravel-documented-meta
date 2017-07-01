<?php

namespace LaravelDocumentedMeta\Tests\Integration;

use LaravelDocumentedMeta\Attribute\MetaAttribute;
use LaravelDocumentedMeta\Tests\Fixtures\Subject\DifferentSubjectFixture;
use LaravelDocumentedMeta\Tests\Fixtures\MetaAttributeFixture;
use LaravelDocumentedMeta\Tests\Fixtures\Subject\MetaSubjectFixture;
use LaravelDocumentedMeta\Tests\Fixtures\Subject\SubjectWithParentFixture;
use LaravelDocumentedMeta\Tests\TestCase;

class MetaSubjectTest extends TestCase
{
    /** @var  MetaSubjectFixture */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new MetaSubjectFixture();
    }

    public function test_it_should_have_default_value()
    {
        $this->assertEquals('none', $this->subject->getMeta(MetaAttributeFixture::class));
    }

    public function test_it_should_retrieve_values() {
        $this->assertEquals(true, $this->subject->setMeta(MetaAttributeFixture::class, 'test'));
        $this->assertEquals('test', $this->subject->getMeta(MetaAttributeFixture::class));
    }

    public function test_it_should_not_retrieve_another_subject_meta() {
        $this->subject->setMeta(MetaAttributeFixture::class, 'test');
        $differentSubject = new DifferentSubjectFixture();
        $this->assertEquals('none', $differentSubject->getMeta(MetaAttributeFixture::class), "A different subject should not get another subject's data");
    }

    public function test_it_should_override_another_meta() {
        $this->subject = new SubjectWithParentFixture();
        $this->subject->getParentMetaSubject()->setMeta(MetaAttributeFixture::class, 'foo');
        $this->assertEquals('foo', $this->subject->getMeta(MetaAttributeFixture::class));
        $this->subject->setMeta(MetaAttributeFixture::class, 'foo.bar');
        $this->assertEquals('foo.bar',  $this->subject->getMeta(MetaAttributeFixture::class));
    }
}