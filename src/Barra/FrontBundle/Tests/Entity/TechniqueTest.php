<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\FrontBundle\Entity\Reference;
use Barra\FrontBundle\Entity\Technique;

/**
 * Class TechniqueTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class TechniqueTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN                 = 'Barra\FrontBundle\Entity\Technique';
    const AGENCY_FQDN               = 'Barra\FrontBundle\Entity\Agency';
    const REFERENCE_FQDN            = 'Barra\FrontBundle\Entity\Reference';
    const ID                        = 2;
    const URL                       = 'demoUrl';
    const NAME                      = 'demoName';
    const DESCRIPTION               = 'demoDescription';

    /** @var  Technique $model */
    protected $model;

    /**
     * Initialises model entity
     */
    public function setUp()
    {
        $this->model = new Technique();
    }

    /**
     * Sets protected id field first to test the get function
     * @test
     */
    public function getId()
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
     * @test
     * @return Technique
     */
    public function setDescription()
    {
        $resource = $this->model->setDescription(self::DESCRIPTION);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setDescription
     * @param Technique $self
     */
    public function getDescription(Technique $self)
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
     * @test
     * @return Technique
     */
    public function setUrl()
    {
        $resource = $this->model->setUrl(self::URL);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setUrl
     * @param Technique $self
     */
    public function getUrl(Technique $self)
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
     * @test
     * @return Technique
     */
    public function setNameTest()
    {
        $resource = $this->model->setName(self::NAME);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setNameTest
     * @param Technique $self
     */
    public function getNameTest(Technique $self)
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
     * @test
     * @return Technique
     */
    public function addReference()
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
     * @test
     * @depends addReference
     * @param Technique $self
     * @return Reference
     */
    public function getReferences(Technique $self)
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
     * @test
     * @depends addReference
     * @depends getReferences
     * @param Technique $self
     * @param Reference $technique
     */
    public function removeReference(Technique $self, Reference $technique)
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

    /**
     * @test
     * @expectedException PHPUnit_Framework_Error
     */
    public function addInvalidReference()
    {
        $this->model->addReference(1);
    }

    /**
     * @test
     * @expectedException PHPUnit_Framework_Error
     */
    public function removeInvalidReference()
    {
        $this->model->removeReference(1);
    }

    /**
     * @test
     * @param string    $field
     * @param mixed     $value
     * @expectedException \InvalidArgumentException
     * @dataProvider providerSetInvalidNativeValues
     */
    public function setInvalidNativeValues($field, $value)
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
