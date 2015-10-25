<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\AdminBundle\Entity\Reference;
use Barra\AdminBundle\Entity\Technique;

/**
 * Class TechniqueTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class TechniqueTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN                 = 'Barra\AdminBundle\Entity\Technique';
    const AGENCY_FQDN               = 'Barra\AdminBundle\Entity\Agency';
    const REFERENCE_FQDN            = 'Barra\AdminBundle\Entity\Reference';
    const ID                        = 2;
    const URL                       = 'demoUrl';
    const NAME                      = 'demoName';
    const DESCRIPTION               = 'demoDescription';


    /** @var  Technique */
    protected $model;


    public function setUp()
    {
        $this->model = new Technique();
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
     * @return Technique
     */
    public function testSetDescription()
    {
        $resource = $this->model->setDescription(self::DESCRIPTION);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testSetDescription
     * @param Technique $self
     */
    public function testGetDescription(Technique $self)
    {
        $got = $self->getDescription();
        $this->assertInternalType(
            'string',
            $got
        );

        $this->assertEquals(
            self::DESCRIPTION,
            $got
        );
    }


    /**
     * @return Technique
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
     * @param Technique $self
     */
    public function testGetUrl(Technique $self)
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
     * @return Technique
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
     * @param Technique $self
     */
    public function testGetName(Technique $self)
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
     * @return Technique
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
     * @param Technique $self
     * @return Reference
     */
    public function testGetReferences(Technique $self)
    {
        $techniques = $self->getReferences();
        $technique  = $techniques[0];

        $this->assertCount(
            1,
            $techniques
        );

        $mock = $this->getMock(self::REFERENCE_FQDN);
        $this->assertEquals(
            $mock,
            $technique
        );

        return $technique;
    }


    /**
     * @depends testAddReference
     * @depends testGetReferences
     * @param Technique $self
     * @param Reference $technique
     */
    public function testremoveReference(Technique $self, Reference $technique)
    {
        $resource = $self->removeReference($technique);
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
                'description',
                1,
            ],
            [
                'url',
                1
            ],
            [
                'name',
                1,
            ],
        ];
    }
}
