<?php

namespace Barra\RecipeBundle\Tests\Entity;

use Barra\RecipeBundle\Entity\Cooking;
use Barra\RecipeBundle\Entity\Ingredient;
use Barra\RecipeBundle\Entity\Recipe;
use Barra\RecipeBundle\Entity\Photo;

/**
 * Class RecipeTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RecipeBundle\Tests\Entity
 */
class RecipeTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN         = 'Barra\RecipeBundle\Entity\Recipe';
    const PHOTO_FQDN        = 'Barra\RecipeBundle\Entity\Photo';
    const INGREDIENT_FQDN   = 'Barra\RecipeBundle\Entity\Ingredient';
    const COOKING_FQDN      = 'Barra\RecipeBundle\Entity\Cooking';
    const ID                = 2;
    const TITLE             = 'demoName';
    const URL               = 'demoUrl';

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
        $this->assertEquals(self::ID, $got);
    }

    /**
     * @return Recipe
     */
    public function testSetName()
    {
        $resource = $this->model->setName(self::TITLE);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetName
     * @param Recipe $self
     */
    public function testGetName(Recipe $self)
    {
        $this->assertEquals(self::TITLE, $self->getName());
    }

    public function testIsRemovable()
    {
        $this->assertTrue($this->model->isRemovable());
    }

    /**
     * @return Recipe
     */
    public function testAddPhoto()
    {
        $mock     = $this->getMock(self::PHOTO_FQDN);
        $resource = $this->model->addPhoto($mock);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

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
        $this->assertCount(1, $photos);
        $photo  = $photos[0];

        return $photo;
    }

    /**
     * @depends testAddPhoto
     * @depends testGetPhotos
     * @param Recipe $self
     * @param Photo  $photo
     */
    public function testRemovePhoto(Recipe $self, Photo $photo)
    {
        $resource = $self->removePhoto($photo);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);
        $this->assertCount(0, $self->getPhotos());
    }

    // ---------------------------------------------------------------------------------------------------
    /**
     * @return Recipe
     */
    public function testAddIngredient()
    {
        $mock     = $this->getMock(self::INGREDIENT_FQDN);
        $resource = $this->model->addIngredient($mock);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testAddIngredient
     * @param Recipe $self
     * @return Ingredient
     */
    public function testGetIngredients(Recipe $self)
    {
        $ingredients = $self->getIngredients();
        $this->assertCount(1, $ingredients);
        $ingredient  = $ingredients[0];

        return $ingredient;
    }

    /**
     * @depends testAddIngredient
     * @depends testGetIngredients
     * @param Recipe $self
     * @param Ingredient  $ingredient
     */
    public function testRemoveIngredient(Recipe $self, Ingredient $ingredient)
    {
        $resource = $self->removeIngredient($ingredient);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);
        $this->assertCount(0, $self->getIngredients());
    }
    // ---------------------------------------------------------------------------------------------------------

    /**
     * @return Recipe
     */
    public function testAddCooking()
    {
        $mock     = $this->getMock(self::COOKING_FQDN);
        $resource = $this->model->addCooking($mock);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testAddCooking
     * @param Recipe $self
     * @return Cooking
     */
    public function testGetCookings(Recipe $self)
    {
        $cookings = $self->getCookings();
        $this->assertCount(1, $cookings);
        $cooking  = $cookings[0];

        return $cooking;
    }

    /**
     * @depends testAddCooking
     * @depends testGetCookings
     * @param Recipe $self
     * @param Cooking  $cooking
     */
    public function testRemoveCooking(Recipe $self, Cooking $cooking)
    {
        $resource = $self->removeCooking($cooking);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);
        $this->assertCount(0, $self->getCookings());
    }
    // ----------------------------------------------------------------------------------------------------------

    /**
     * @param string    $method
     * @param mixed     $value
     * @expectedException \PHPUnit_Framework_Error
     * @dataProvider providerCollectionsWithInvalidValues
     */
    public function testCollectionsWithInvalidValues($method, $value)
    {
        $this->model->{$method}($value);
    }

    /**
     * Negative tests for add and remove methods of collections
     * @return array
     */
    public static function providerCollectionsWithInvalidValues()
    {
        return [
            [
                'addPhoto',
                1,
            ],
            [
                'removePhoto',
                1,
            ],
            [
                'addIngredient',
                1,
            ],
            [
                'removeIngredient',
                1,
            ],
            [
                'addCooking',
                1,
            ],
            [
                'removeCooking',
                1,
            ],
        ];
    }
}
