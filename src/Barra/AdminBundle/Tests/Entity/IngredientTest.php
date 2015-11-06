<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\AdminBundle\Entity\Ingredient;
use Barra\AdminBundle\Entity\Measurement;
use Barra\AdminBundle\Entity\Product;
use Barra\AdminBundle\Entity\Recipe;

/**
 * Class IngredientTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class IngredientTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN         = 'Barra\AdminBundle\Entity\Ingredient';
    const RECIPE_FQDN       = 'Barra\AdminBundle\Entity\Recipe';
    const PRODUCT_FQDN      = 'Barra\AdminBundle\Entity\Product';
    const MEASUREMENT_FQDN  = 'Barra\AdminBundle\Entity\Measurement';
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
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testSetPosition
     * @param Ingredient $self
     */
    public function testGetPosition(Ingredient $self)
    {
        $got = $self->getPosition();
        $this->assertInternalType(
            'int',
            $got
        );

        $this->assertEquals(
            self::POSITION,
            $got
        );
    }


    /**
     * @return Ingredient
     */
    public function testSetAmount()
    {
        $resource = $this->model->setAmount(self::AMOUNT);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testSetAmount
     * @param Ingredient $self
     */
    public function testGetAmount(Ingredient $self)
    {
        $got = $self->getAmount();
        $this->assertInternalType(
            'int',
            $got
        );

        $this->assertEquals(
            self::AMOUNT,
            $got
        );
    }


    /**
     * @return Ingredient
     */
    public function testSetRecipe()
    {
        $mock     = $this->getMock(self::RECIPE_FQDN);
        $resource = $this->model->setRecipe($mock);

        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testSetRecipe
     * @param Ingredient $self
     */
    public function testGetRecipe(Ingredient $self)
    {
        $mock   = $this->getMock(self::RECIPE_FQDN);
        $recipe = $self->getRecipe();

        $this->assertEquals(
            $mock,
            $recipe
        );
    }


    /**
     * @return Ingredient
     */
    public function testSetProduct()
    {
        $mock     = $this->getMock(self::PRODUCT_FQDN);
        $resource = $this->model->setProduct($mock);

        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testSetProduct
     * @param Ingredient $self
     */
    public function testGetProduct(Ingredient $self)
    {
        $mock    = $this->getMock(self::PRODUCT_FQDN);
        $product = $self->getProduct();

        $this->assertEquals(
            $mock,
            $product
        );
    }


    /**
     * @return Ingredient
     */
    public function testSetMeasurement()
    {
        $mock     = $this->getMock(self::MEASUREMENT_FQDN);
        $resource = $this->model->setMeasurement($mock);

        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testSetMeasurement
     * @param Ingredient $self
     */
    public function testGetMeasurement(Ingredient $self)
    {
        $mock        = $this->getMock(self::MEASUREMENT_FQDN);
        $measurement = $self->getMeasurement();

        $this->assertEquals(
            $mock,
            $measurement
        );
    }


    /**
     * @expectedException \RuntimeException
     */
    public function testCreateIdNegativeTest()
    {
        $this->model->createId();
    }


    /**
     * @depends testSetRecipe
     * @return Ingredient
     */
    public function testCreateId()
    {
        $recipeMock = $this->getMock(self::RECIPE_FQDN);
        $recipeMock
            ->expects($this->exactly(2))
            ->method('getId')
            ->will($this->returnValue(self::ID))
        ;
        $this->model->setRecipe($recipeMock);


        $productMock = $this->getMock(self::PRODUCT_FQDN);
        $productMock
            ->expects($this->exactly(2))
            ->method('getId')
            ->will($this->returnValue(self::PRODUCT_ID))
        ;
        $this->model->setProduct($productMock);

        $resource = $this->model->createId();
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testCreateId
     * @param Ingredient $self
     */
    public function testGetId(Ingredient $self)
    {
        $this->assertEquals(
            self::ID.self::PRODUCT_ID,
            $self->getId()
        );
    }


    /**
     */
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
                'position',
                '1',
            ],
            [
                'amount',
                '1'
            ]
        ];
    }
}
