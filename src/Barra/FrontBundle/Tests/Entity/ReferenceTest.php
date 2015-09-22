<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\FrontBundle\Entity\Reference;
use Barra\FrontBundle\Entity\ReferencePicture;
use Barra\FrontBundle\Entity\Technique;

/**
 * Class ReferenceTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class ReferenceTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN                 = 'Barra\FrontBundle\Entity\Reference';
    const AGENCY_FQDN               = 'Barra\FrontBundle\Entity\Agency';
    const TECHNIQUE_FQDN            = 'Barra\FrontBundle\Entity\Technique';
    const REFERENCE_PICTURE_FQDN    = 'Barra\FrontBundle\Entity\ReferencePicture';
    const ID                        = 2;
    const DESCRIPTION               = 'demoDescription';

    /** @var  Reference $model */
    protected $model;
    protected $started;
    protected $finished;

    /**
     * Initialises model entity
     */
    public function setUp()
    {
        $this->model    = new Reference();
        $this->started  = new \DateTime('01.01.2000');
        $this->finished = new \DateTime('12.12.2000');
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
     * @return Reference
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
     * @param Reference $self
     */
    public function getDescription(Reference $self)
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
     * @return Reference
     */
    public function setStarted()
    {
        $resource = $this->model->setStarted($this->started);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setStarted
     * @param Reference $self
     */
    public function getStarted(Reference $self)
    {
        $got = $self->getStarted();
        $this->assertEquals(
            $this->started,
            $got
        );
    }

    /**
     * @test
     * @return Reference
     */
    public function setFinished()
    {
        $resource = $this->model->setFinished($this->finished);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setFinished
     * @param Reference $self
     */
    public function getFinished(Reference $self)
    {
        $got = $self->getFinished();
        $this->assertEquals(
            $this->finished,
            $got
        );
    }

    /**
     * @test
     * @return Reference
     */
    public function setAgency()
    {
        $mock     = $this->getMock(self::AGENCY_FQDN);
        $resource = $this->model->setAgency($mock);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setAgency
     * @param Reference $self
     */
    public function getAgency(Reference $self)
    {
        $mock   = $this->getMock(self::AGENCY_FQDN);
        $agency = $self->getAgency();

        $this->assertEquals(
            $mock,
            $agency
        );
    }
    
    /**
     * @test
     * @return Reference
     */
    public function addTechnique()
    {
        $mock     = $this->getMock(self::TECHNIQUE_FQDN);
        $resource = $this->model->addTechnique($mock);

        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends addTechnique
     * @param Reference $self
     * @return Technique
     */
    public function getTechniques(Reference $self)
    {
        $techniques = $self->getTechniques();
        $technique  = $techniques[0];

        $this->assertCount(
            1,
            $techniques
        );

        $mock = $this->getMock(self::TECHNIQUE_FQDN);
        $this->assertEquals(
            $mock,
            $technique
        );

        return $technique;
    }

    /**
     * @test
     * @depends addTechnique
     * @depends getTechniques
     * @param Reference $self
     * @param Technique $technique
     */
    public function removeTechnique(Reference $self, Technique $technique)
    {
        $resource = $self->removeTechnique($technique);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        $this->assertCount(
            0,
            $self->getTechniques()
        );
    }

    /**
     * @test
     * @expectedException PHPUnit_Framework_Error
     */
    public function addInvalidTechnique()
    {
        $this->model->addTechnique(1);
    }

    /**
     * @test
     * @expectedException PHPUnit_Framework_Error
     */
    public function removeInvalidTechnique()
    {
        $this->model->removeTechnique(1);
    }

    /**
     * @test
     * @return Reference
     */
    public function addReferencePicture()
    {
        $mock     = $this->getMock(self::REFERENCE_PICTURE_FQDN);
        $resource = $this->model->addReferencePicture($mock);

        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends addReferencePicture
     * @param Reference $self
     * @return ReferencePicture
     */
    public function getReferencePictures(Reference $self)
    {
        $pics = $self->getReferencePictures();
        $pic  = $pics[0];

        $this->assertCount(
            1,
            $pics
        );

        $mock = $this->getMock(self::REFERENCE_PICTURE_FQDN);
        $this->assertEquals(
            $mock,
            $pic
        );

        return $pic;
    }


    /**
     * @test
     * @depends addReferencePicture
     * @depends getReferencePictures
     * @param Reference         $self
     * @param ReferencePicture  $pic
     */
    public function removeReferencePicture(Reference $self, ReferencePicture $pic)
    {
        $resource = $self->removeReferencePicture($pic);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        $this->assertCount(
            0,
            $self->getReferencePictures()
        );
    }

    /**
     * @test
     * @expectedException PHPUnit_Framework_Error
     */
    public function addInvalidReferencePicture()
    {
        $this->model->addReferencePicture(1);
    }

    /**
     * @test
     * @expectedException PHPUnit_Framework_Error
     */
    public function removeInvalidReferencePicture()
    {
        $this->model->removeReferencePicture(1);
    }

    /**
     * @test
     * @param string    $field
     * @param mixed     $value
     * @expectedException PHPUnit_Framework_Error
     * @dataProvider providerSetInvalidComplexValues
     */
    public function setInvalidComplexValues($field, $value)
    {
        $this->model->{'set'.ucfirst($field)}($value);
    }

    /**
     * Invalid complex values for setter
     * @return array
     */
    public static function providerSetInvalidComplexValues()
    {
        return [
            [
                'started',
                '01.01.2000',
            ],
            [
                'finished',
                '12.12.2000',
            ],
            [
                'agency',
                1,
            ],
        ];
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
                1,
            ],
        ];
    }
}
