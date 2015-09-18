<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\FrontBundle\Entity\Agency;
use Barra\FrontBundle\Entity\Reference;

/**
 * Class AgencyTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class AgencyTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN         = 'Barra\FrontBundle\Entity\Agency';
    const REFERENCE_FQDN    = 'Barra\FrontBundle\Entity\Reference';
    const ID                = 2;
    const TITLE             = 'demoName';
    const URL               = 'demoUrl';

    /** @var  Agency $model */
    protected $model;

    /**
     * Initialises model entity
     */
    public function setUp()
    {
        $this->model = new Agency();
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
     * @return Agency
     */
    public function setNameTest()
    {
        $resource = $this->model->setName(self::TITLE);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setNameTest
     * @param Agency $self
     */
    public function getNameTest(Agency $self)
    {
        $got = $self->getName();
        $this->assertInternalType(
            'string',
            $got
        );

        $this->assertEquals(
            self::TITLE,
            $got
        );
    }

    /**
     * @test
     * @return Agency
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
     * @param Agency $self
     */
    public function getUrl(Agency $self)
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
     * @return Agency
     */
    public function addReference()
    {
        $referenceMock = $this->getMock(self::REFERENCE_FQDN);
        $resource      = $this->model->addReference($referenceMock);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends addReference
     * @param Agency $self
     * @return Reference
     */
    public function getReferences(Agency $self)
    {
        $references  = $self->getReferences();
        $reference   = $references->get(0);

        $this->assertCount(
            1,
            $references
        );

        $referenceMock = $this->getMock(self::REFERENCE_FQDN);
        $this->assertEquals(
            $referenceMock,
            $reference
        );

        return $reference;
    }

    /**
     * @test
     * @depends addReference
     * @depends getReferences
     * @param Agency $self
     * @param Reference   $reference
     */
    public function removeReference(Agency $self, Reference $reference)
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
