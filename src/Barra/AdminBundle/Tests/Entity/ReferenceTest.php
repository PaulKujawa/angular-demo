<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\AdminBundle\Entity\Reference;
use Barra\AdminBundle\Entity\Screenshot;
use Barra\AdminBundle\Entity\Technique;

/**
 * Class ReferenceTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class ReferenceTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN                 = 'Barra\AdminBundle\Entity\Reference';
    const AGENCY_FQDN               = 'Barra\AdminBundle\Entity\Agency';
    const TECHNIQUE_FQDN            = 'Barra\AdminBundle\Entity\Technique';
    const REFERENCE_PICTURE_FQDN    = 'Barra\AdminBundle\Entity\Screenshot';
    const ID                        = 2;
    const DESCRIPTION               = 'demoDescription';


    /** @var  Reference */
    protected $model;
    protected $started;
    protected $finished;


    public function setUp()
    {
        $this->model    = new Reference();
        $this->started  = new \DateTime('01.01.2000');
        $this->finished = new \DateTime('12.12.2000');
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
     * @return Reference
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
     * @param Reference $self
     */
    public function testGetDescription(Reference $self)
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
     * @return Reference
     */
    public function testSetStarted()
    {
        $resource = $this->model->setStarted($this->started);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testSetStarted
     * @param Reference $self
     */
    public function testGetStarted(Reference $self)
    {
        $got = $self->getStarted();
        $this->assertEquals(
            $this->started,
            $got
        );
    }


    /**
     * @return Reference
     */
    public function testSetFinished()
    {
        $resource = $this->model->setFinished($this->finished);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testSetFinished
     * @param Reference $self
     */
    public function testGetFinished(Reference $self)
    {
        $got = $self->getFinished();
        $this->assertEquals(
            $this->finished,
            $got
        );
    }


    /**
     * @return Reference
     */
    public function testSetAgency()
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
     * @depends testSetAgency
     * @param Reference $self
     */
    public function testGetAgency(Reference $self)
    {
        $mock   = $this->getMock(self::AGENCY_FQDN);
        $agency = $self->getAgency();

        $this->assertEquals(
            $mock,
            $agency
        );
    }
    

    /**
     * @return Reference
     */
    public function testAddTechnique()
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
     * @depends testAddTechnique
     * @param Reference $self
     * @return Technique
     */
    public function testGetTechniques(Reference $self)
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
     * @depends testAddTechnique
     * @depends testGetTechniques
     * @param Reference $self
     * @param Technique $technique
     */
    public function testRemoveTechnique(Reference $self, Technique $technique)
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
     * @expectedException PHPUnit_Framework_Error
     */
    public function testAddInvalidTechnique()
    {
        $this->model->addTechnique(1);
    }


    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testRemoveInvalidTechnique()
    {
        $this->model->removeTechnique(1);
    }


    /**
     * @return Reference
     */
    public function testAddScreenshot()
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
     * @depends testAddScreenshot
     * @param Reference $self
     * @return Screenshot
     */
    public function testGetScreenshots(Reference $self)
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
     * @depends testAddScreenshot
     * @depends testGetScreenshots
     * @param Reference         $self
     * @param Screenshot  $pic
     */
    public function testRemoveScreenshot(Reference $self, Screenshot $pic)
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


    public function testIsRemovableTrue()
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
     * @expectedException PHPUnit_Framework_Error
     */
    public function testAddInvalidScreenshot()
    {
        $this->model->addScreenshot(1);
    }


    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testRemoveInvalidScreenshot()
    {
        $this->model->removeScreenshot(1);
    }


    /**
     * @param string    $field
     * @param mixed     $value
     * @expectedException PHPUnit_Framework_Error
     * @dataProvider providerSetInvalidComplexValues
     */
    public function testSetInvalidComplexValues($field, $value)
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
                1,
            ],
        ];
    }
}
