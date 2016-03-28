<?php

namespace Barra\RecipeBundle\Tests\Entity;

use Barra\RecipeBundle\Entity\Measurement;
use Barra\RecipeBundle\Entity\Ingredient;
use PHPUnit_Framework_Error;

class MeasurementTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN = 'Barra\RecipeBundle\Entity\Measurement';
    const INGREDIENT_FQDN = 'Barra\RecipeBundle\Entity\Ingredient';
    const ID = 2;
    const GR = 22;
    const NAME = 'demoName';

    /** @var  Measurement */
    protected $model;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->model = new Measurement();
    }

    /**
     * Sets protected id field first to test the get function
     */
    public function testGetId()
    {
        $reflected = new \ReflectionClass(self::SELF_FQDN);
        $idField = $reflected->getProperty('id');
        $idField->setAccessible(true);
        $idField->setValue($this->model, self::ID);

        $got = $this->model->getId();
        $this->assertEquals(self::ID, $got);
    }

    /**
     *
     * @return Measurement
     */
    public function testSetGr()
    {
        $resource = $this->model->setGr(self::GR);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetGr
     *
     * @param Measurement $self
     */
    public function testGetGr(Measurement $self)
    {
        $this->assertEquals(self::GR, $self->getGr());
    }

    /**
     * @return Measurement
     */
    public function testSetName()
    {
        $resource = $this->model->setName(self::NAME);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetName
     *
     * @param Measurement $self
     */
    public function testGetName(Measurement $self)
    {
        $this->assertEquals(self::NAME, $self->getName());
    }

    /**
     * @return Measurement
     */
    public function testAddIngredient()
    {
        $mock = $this->getMock(self::INGREDIENT_FQDN);
        $resource = $this->model->addIngredient($mock);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testAddIngredient
     *
     * @param Measurement $self
     *
     * @return Ingredient
     */
    public function testGetIngredients(Measurement $self)
    {
        $ingredients = $self->getIngredients();
        $this->assertCount(1, $ingredients);

        return $ingredients[0];
    }

    /**
     * @depends testAddIngredient
     * @depends testGetIngredients
     *
     * @param Measurement $self
     * @param Ingredient $ingredient
     */
    public function testRemoveIngredient(Measurement $self, Ingredient $ingredient)
    {
        $resource = $self->removeIngredient($ingredient);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);
        $this->assertCount(0, $self->getIngredients());
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testAddInvalidIngredient()
    {
        $this->model->addIngredient(1);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testRemoveInvalidIngredient()
    {
        $this->model->removeIngredient(1);
    }

    public function testIsRemovable()
    {
        $this->assertTrue($this->model->isRemovable());

        $mock = $this->getMock(self::INGREDIENT_FQDN);
        $this->model->addIngredient($mock);
        $this->assertFalse($this->model->isRemovable());
    }
}
