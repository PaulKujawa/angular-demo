<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\AdminBundle\Entity\Recipe;
use Barra\AdminBundle\Entity\Photo;

/**
 * Class RecipeTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class RecipeTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN     = 'Barra\AdminBundle\Entity\Recipe';
    const PHOTO_FQDN    = 'Barra\AdminBundle\Entity\Photo';
    const ID            = 2;
    const TITLE         = 'demoName';
    const URL           = 'demoUrl';


    /** @var  Recipe */
    protected $model;


    public function setUp()
    {
        $this->model = new Recipe();
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
     * @return Recipe
     */
    public function testSetName()
    {
        $resource = $this->model->setName(self::TITLE);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testSetName
     * @param Recipe $self
     */
    public function testGetName(Recipe $self)
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
     * @return Recipe
     */
    public function testAddPhoto()
    {
        $mock     = $this->getMock(self::PHOTO_FQDN);
        $resource = $this->model->addPhoto($mock);

        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testAddPhoto
     * @param Recipe $self
     * @return Photo
     */
    public function testGetPhotos(Recipe $self)
    {
        $photos = $self->getPhotos();
        $photo  = $photos[0];

        $this->assertCount(
            1,
            $photos
        );

        $mock = $this->getMock(self::PHOTO_FQDN);
        $this->assertEquals(
            $mock,
            $photo
        );

        return $photo;
    }


    /**
     * @depends testAddPhoto
     * @depends testGetPhotos
     * @param Recipe $self
     * @param Photo  $photo
     */
    public function testremovePhoto(Recipe $self, Photo $photo)
    {
        $resource = $self->removePhoto($photo);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        $this->assertCount(
            0,
            $self->getPhotos()
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


    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testAddInvalidPhoto()
    {
        $this->model->addPhoto(1);
    }


    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testremoveInvalidPhoto()
    {
        $this->model->removePhoto(1);
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
        ];
    }
}
