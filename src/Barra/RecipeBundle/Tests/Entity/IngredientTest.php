<?php

namespace Barra\RecipeBundle\Tests\Entity;

use Barra\RecipeBundle\Entity\Ingredient;
use Barra\RecipeBundle\Entity\Measurement;
use Barra\RecipeBundle\Entity\Product;
use Barra\RecipeBundle\Entity\Recipe;

/**
 * Class IngredientTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RecipeBundle\Tests\Entity
 */
class IngredientTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN         = 'Barra\RecipeBundle\Entity\Ingredient';
    const RECIPE_FQDN       = 'Barra\RecipeBundle\Entity\Recipe';
    const PRODUCT_FQDN      = 'Barra\RecipeBundle\Entity\Product';
    const MEASUREMENT_FQDN  = 'Barra\RecipeBundle\Entity\Measurement';
    const ID                = 222;
    const PRODUCT_ID        = 333;
    const POSITION          = 22;
    const AMOUNT            = 11;

    /** @var  Ingredient */
    protected $model;

    public function setUp()
    {
        $this->model = new Ingredient();
    }

    /**
     * @return Ingredient
     */
    public function testSetPosition()
    {
        $resource = $this->model->setPosition(self::POSITION);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetPosition
     * @param Ingredient $self
     */
    public function testGetPosition(Ingredient $self)
    {
        $this->assertEquals(self::POSITION, $self->getPosition());
    }

    /**
     * @return Ingredient
     */
    public function testSetAmount()
    {
        $resource = $this->model->setAmount(self::AMOUNT);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetAmount
     * @param Ingredient $self
     */
    public function testGetAmount(Ingredient $self)
    {
        $this->assertEquals(self::AMOUNT, $self->getAmount());
    }

    /**
     * @return Ingredient
     */
    public function testSetRecipe()
    {
        $mock     = $this->getMock(self::RECIPE_FQDN);
        $resource = $this->model->setRecipe($mock);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetRecipe
     * @param Ingredient $self
     */
    public function testGetRecipe(Ingredient $self)
    {
        $this->assertNotNull($self->getRecipe());
    }

    /**
     * @return Ingredient
     */
    public function testSetProduct()
    {
        $mock     = $this->getMock(self::PRODUCT_FQDN);
        $resource = $this->model->setProduct($mock);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetProduct
     * @param Ingredient $self
     */
    public function testGetProduct(Ingredient $self)
    {
        $this->assertNotNull($self->getProduct());
    }

    /**
     * @return Ingredient
     */
    public function testSetMeasurement()
    {
        $mock     = $this->getMock(self::MEASUREMENT_FQDN);
        $resource = $this->model->setMeasurement($mock);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetMeasurement
     * @param Ingredient $self
     */
    public function testGetMeasurement(Ingredient $self)
    {
        $this->assertNotNull($self->getMeasurement());
    }

    public function testIsRemovable()
    {
        $this->assertTrue($this->model->isRemovable());
    }

    /**
     * @param string    $field
     * @param mixed     $value
     * @expectedException \PHPUnit_Framework_Error
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
                'recipe',
                1,
            ],
            [
                'product',
                1,
            ],
            [
                'measurement',
                1,
            ],
        ];
    }
}
