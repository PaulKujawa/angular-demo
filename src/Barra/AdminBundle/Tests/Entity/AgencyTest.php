<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\AdminBundle\Entity\Agency;
use Barra\AdminBundle\Entity\Reference;

/**
 * Class AgencyTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class AgencyTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN         = 'Barra\AdminBundle\Entity\Agency';
    const REFERENCE_FQDN    = 'Barra\AdminBundle\Entity\Reference';
    const ID                = 2;
    const NAME             = 'demoName';
    const URL               = 'demoUrl';


    /** @var  Agency */
    protected $model;


    public function setUp()
    {
        $this->model = new Agency();
    }


    /**
     * Sets protected id field first to test the get function
     */
    public function testGetId()
    {
        $reflected = new \ReflectionClass(self::SELF_FQDN);
        $idField   = $reflected->getProperty('id');
        $idField->setAccessible(true);
        $idField->setValue($this->model, self::ID);

        $got = $this->model->getId();
        $this->assertInternalType(
            'int',
            $got
        );

        $this->assertEquals(
            self::ID,
            $got
        );
    }


    /**
     * @return Agency
     */
    public function testSetName()
    {
        $resource = $this->model->setName(self::NAME);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testSetName
     * @param Agency $self
     */
    public function testGetName(Agency $self)
    {
        $got = $self->getName();
        $this->assertInternalType(
            'string',
            $got
        );

        $this->assertEquals(
            self::NAME,
            $got
        );
    }


    /**
     * @return Agency
     */
    public function testSetUrl()
    {
        $resource = $this->model->setUrl(self::URL);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testSetUrl
     * @param Agency $self
     */
    public function testGetUrl(Agency $self)
    {
        $got = $self->getUrl();
        $this->assertInternalType(
            'string',
            $got
        );

        $this->assertEquals(
            self::URL,
            $got
        );
    }


    /**
     * @return Agency
     */
    public function testAddReference()
    {
        $mock     = $this->getMock(self::REFERENCE_FQDN);
        $resource = $this->model->addReference($mock);

        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testAddReference
     * @param Agency $self
     * @return Reference
     */
    public function testGetReferences(Agency $self)
    {
        $references = $self->getReferences();
        $reference  = $references[0];

        $this->assertCount(
            1,
            $references
        );

        $mock = $this->getMock(self::REFERENCE_FQDN);
        $this->assertEquals(
            $mock,
            $reference
        );

        return $reference;
    }


    /**
     * @depends testAddReference
     * @depends testGetReferences
     * @param Agency    $self
     * @param Reference $reference
     */
    public function testremoveReference(Agency $self, Reference $reference)
    {
        $resource = $self->removeReference($reference);

        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        $this->assertCount(
            0,
            $self->getReferences()
        );
    }


    public function testisRemovableTrue()
    {
        $got = $this->model->isRemovable();
        $this->assertInternalType(
            'bool',
            $got
        );

        $this->assertEquals(
            true,
            $got
        );
    }


    public function testisRemovableFalse()
    {
        $mock = $this->getMock(self::REFERENCE_FQDN);
        $this->model->addReference($mock);
        $got  = $this->model->isRemovable();

        $this->assertInternalType(
            'bool',
            $got
        );

        $this->assertEquals(
            false,
            $got
        );
    }


    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testAddInvalidReference()
    {
        $this->model->addReference(1);
    }


    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testremoveInvalidReference()
    {
        $this->model->removeReference(1);
    }


    /**
     * @param string    $field
     * @param mixed     $value
     * @expectedException \InvalidArgumentException
     * @dataProvider providerSetInvalidNativeValues
     */
    public function testSetInvalidNativeValues($field, $value)
    {
        $this->model->{'set'.ucfirst($field)}($value);
    }


    /**
     * Invalid native values for setter
     * @return array
     */
    public static function providerSetInvalidNativeValues()
    {
        return [
            [
                'name',
                1,
            ],
            [
                'url',
                1,
            ],
        ];
    }
}
