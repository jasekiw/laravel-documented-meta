<?php

namespace LaravelDocumentedMeta\Tests\Integration;

use LaravelDocumentedMeta\Tests\Fixtures\MetaAttribute\StringAttributeFixture;
use LaravelDocumentedMeta\Tests\Fixtures\Subject\DifferentSubjectFixture;
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
        $this->assertEquals('none', $this->subject->getMeta(StringAttributeFixture::class));
    }

    public function test_it_should_retrieve_values() {
        $this->assertEquals(true, $this->subject->setMeta(StringAttributeFixture::class, 'test'));
        $this->assertEquals('test', $this->subject->getMeta(StringAttributeFixture::class));
    }

    public function test_it_should_not_retrieve_another_subject_meta() {
        $this->subject->setMeta(StringAttributeFixture::class, 'test');
        $differentSubject = new DifferentSubjectFixture();
        $this->assertEquals('none', $differentSubject->getMeta(StringAttributeFixture::class), "A different subject should not get another subject's data");
    }

    public function test_it_should_override_another_meta() {
        $this->subject = new SubjectWithParentFixture();
        $this->subject->getParentMetaSubject()->setMeta(StringAttributeFixture::class, 'foo');
        $this->assertEquals('foo', $this->subject->getMeta(StringAttributeFixture::class));
        $this->subject->setMeta(StringAttributeFixture::class, 'foo.bar');
        $this->assertEquals('foo.bar',  $this->subject->getMeta(StringAttributeFixture::class));
    }

    public function test_it_should_retrieveConfiguration() {

        $attributes = $this->subject->getMetaConfiguration();
        $this->assertEquals('testOption', $attributes['nested']['namespace'][0]['name'], "The attribute should show in the correct location and have the correct name");
        $this->assertEquals('namespace.testOption', $attributes['flat'][0]['name'], "The attribute should show in the correct location and have the correct name");
        $this->assertEquals('namespace.testOption', $attributes['flat'][0]['name'], "The attribute should show in the correct location and have the correct name");
    }

    public function test_it_should_retrieveDefault() {

        $this->assertEquals('none',$this->subject->getMetaAttribute(StringAttributeFixture::class)->toArray()['value']);
    }
}