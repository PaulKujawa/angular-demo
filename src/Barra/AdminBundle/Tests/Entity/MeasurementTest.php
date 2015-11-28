<?php

namespace Barra\AdminBundle\Tests\Entity;

use Barra\AdminBundle\Entity\Measurement;
use Barra\AdminBundle\Entity\Ingredient;

/**
 * Class MeasurementTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Tests\Entity
 */
class MeasurementTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN         = 'Barra\AdminBundle\Entity\Measurement';
    const INGREDIENT_FQDN   = 'Barra\AdminBundle\Entity\Ingredient';
    const ID                = 2;
    const GR                = 22;
    const NAME              = 'demoName';

    /** @var  Measurement */
    protected $model;

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
        $idField   = $reflected->getProperty('id');
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
        $mock     = $this->getMock(self::INGREDIENT_FQDN);
        $resource = $this->model->addIngredient($mock);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testAddIngredient
     * @param Measurement $self
     * @return Ingredient
     */
    public function testGetIngredients(Measurement $self)
    {
        $ingredients = $self->getIngredients();
        $this->assertCount(1, $ingredients);
        $ingredient  = $ingredients[0];

        return $ingredient;
    }


    /**
     * @depends testAddIngredient
     * @depends testGetIngredients
     * @param Measurement  $self
     * @param Ingredient       $ingredient
     */
    public function testRemoveIngredient(Measurement $self, Ingredient $ingredient)
    {
        $resource = $self->removeIngredient($ingredient);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);
        $this->assertCount(0, $self->getIngredients());
    }

    /**
     * @expectedException \PHPUnit_Framework_Error
     */
    public function testAddInvalidIngredient()
    {
        $this->model->addIngredient(1);
    }

    /**
     * @expectedException \PHPUnit_Framework_Error
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
