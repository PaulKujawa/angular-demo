<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\BackBundle\Entity\Reference;
use Barra\BackBundle\Entity\Screenshot;
use Barra\BackBundle\Entity\Technique;

/**
 * Class ReferenceTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class ReferenceTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN                 = 'Barra\BackBundle\Entity\Reference';
    const AGENCY_FQDN               = 'Barra\BackBundle\Entity\Agency';
    const TECHNIQUE_FQDN            = 'Barra\BackBundle\Entity\Technique';
    const REFERENCE_PICTURE_FQDN    = 'Barra\BackBundle\Entity\Screenshot';
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
    public function addScreenshot()
    {
        $mock     = $this->getMock(self::REFERENCE_PICTURE_FQDN);
        $resource = $this->model->addScreenshot($mock);

        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends addScreenshot
     * @param Reference $self
     * @return Screenshot
     */
    public function getScreenshots(Reference $self)
    {
        $pics = $self->getScreenshots();
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
     * @depends addScreenshot
     * @depends getScreenshots
     * @param Reference         $self
     * @param Screenshot  $pic
     */
    public function removeScreenshot(Reference $self, Screenshot $pic)
    {
        $resource = $self->removeScreenshot($pic);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        $this->assertCount(
            0,
            $self->getScreenshots()
        );
    }

    /**
     * @test
     */
    public function isRemovableTrue()
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

    /**
     * @test
     * @expectedException PHPUnit_Framework_Error
     */
    public function addInvalidScreenshot()
    {
        $this->model->addScreenshot(1);
    }

    /**
     * @test
     * @expectedException PHPUnit_Framework_Error
     */
    public function removeInvalidScreenshot()
    {
        $this->model->removeScreenshot(1);
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
