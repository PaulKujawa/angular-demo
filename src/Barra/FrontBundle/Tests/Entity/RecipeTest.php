<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\FrontBundle\Entity\Recipe;
use Barra\FrontBundle\Entity\Photo;

/**
 * Class RecipeTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class RecipeTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN     = 'Barra\FrontBundle\Entity\Recipe';
    const PHOTO_FQDN    = 'Barra\FrontBundle\Entity\Photo';
    const ID            = 2;
    const TITLE         = 'demoName';
    const URL           = 'demoUrl';

    /** @var  Recipe $model */
    protected $model;

    /**
     * Initialises model entity
     */
    public function setUp()
    {
        $this->model = new Recipe();
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
     * @return Recipe
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
     * @param Recipe $self
     */
    public function getNameTest(Recipe $self)
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
     * @return Recipe
     */
    public function addPhoto()
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
     * @test
     * @depends addPhoto
     * @param Recipe $self
     * @return Photo
     */
    public function getPhotos(Recipe $self)
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
     * @test
     * @depends addPhoto
     * @depends getPhotos
     * @param Recipe $self
     * @param Photo  $photo
     */
    public function removePhoto(Recipe $self, Photo $photo)
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

    /**
     * @test
     * @expectedException PHPUnit_Framework_Error
     */
    public function addInvalidPhoto()
    {
        $this->model->addPhoto(1);
    }

    /**
     * @test
     * @expectedException PHPUnit_Framework_Error
     */
    public function removeInvalidPhoto()
    {
        $this->model->removePhoto(1);
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
        ];
    }
}
