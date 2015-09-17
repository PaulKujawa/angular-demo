<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\FrontBundle\Entity\Ingredient;
use Barra\FrontBundle\Entity\Measurement;
use Barra\FrontBundle\Entity\Product;
use Barra\FrontBundle\Entity\Recipe;

/**
 * Class IngredientTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class IngredientTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN         = 'Barra\FrontBundle\Entity\Ingredient';
    const RECIPE_FQDN       = 'Barra\FrontBundle\Entity\Recipe';
    const PRODUCT_FQDN      = 'Barra\FrontBundle\Entity\Product';
    const MEASUREMENT_FQDN  = 'Barra\FrontBundle\Entity\Measurement';
    const ID                = 222;
    const PRODUCT_ID        = 333;
    const POSITION          = 22;
    const AMOUNT            = 11;

    /** @var  Ingredient $model */
    protected $model;

    /**
     * Initialises model entity
     */
    public function setUp()
    {
        $this->model = new Ingredient();
    }

    /**
     * @test
     *
     * @return Ingredient
     */
    public function setPosition()
    {
        $resource = $this->model->setPosition(self::POSITION);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setPosition
     * @param Ingredient $self
     */
    public function getPosition(Ingredient $self)
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
     * @test
     *
     * @return Ingredient
     */
    public function setAmount()
    {
        $resource = $this->model->setAmount(self::AMOUNT);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setAmount
     * @param Ingredient $self
     */
    public function getAmount(Ingredient $self)
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
     * @test
     * @return Ingredient
     */
    public function setRecipe()
    {
        $recipeMock = $this->getMock(self::RECIPE_FQDN);
        $resource   = $this->model->setRecipe($recipeMock);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setRecipe
     * @param Ingredient $self
     * @return Recipe
     */
    public function getRecipe(Ingredient $self)
    {
        $recipe     = $self->getRecipe();
        $recipeMock = $this->getMock(self::RECIPE_FQDN);
        $this->assertEquals(
            $recipeMock,
            $recipe
        );

        return $recipe;
    }

    /**
     * @test
     * @return Ingredient
     */
    public function setProduct()
    {
        $productMock = $this->getMock(self::PRODUCT_FQDN);
        $resource   = $this->model->setProduct($productMock);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setProduct
     * @param Ingredient $self
     * @return Product
     */
    public function getProduct(Ingredient $self)
    {
        $product     = $self->getProduct();
        $productMock = $this->getMock(self::PRODUCT_FQDN);
        $this->assertEquals(
            $productMock,
            $product
        );

        return $product;
    }

    /**
     * @test
     * @return Ingredient
     */
    public function setMeasurement()
    {
        $measurementMock = $this->getMock(self::MEASUREMENT_FQDN);
        $resource   = $this->model->setMeasurement($measurementMock);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setMeasurement
     * @param Ingredient $self
     * @return Measurement
     */
    public function getMeasurement(Ingredient $self)
    {
        $measurement     = $self->getMeasurement();
        $measurementMock = $this->getMock(self::MEASUREMENT_FQDN);
        $this->assertEquals(
            $measurementMock,
            $measurement
        );

        return $measurement;
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function createIdNegativeTest()
    {
        $this->model->createId();
    }

    /**
     * @test
     * @depends setRecipe
     * @return Ingredient
     */
    public function createId()
    {
        $recipeMock = $this->getMock(self::RECIPE_FQDN);
        $recipeMock
            ->expects($this->exactly(2))
            ->method('getId')
            ->will($this->returnValue(self::ID))
        ;

        $productMock = $this->getMock(self::PRODUCT_FQDN);
        $productMock
            ->expects($this->exactly(2))
            ->method('getId')
            ->will($this->returnValue(self::PRODUCT_ID))
        ;

        $this->model->setRecipe($recipeMock);
        $this->model->setProduct($productMock);

        $resource = $this->model->createId();
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends createId
     * @param Ingredient $self
     */
    public function getId(Ingredient $self)
    {
        $this->assertEquals(
            self::ID.self::PRODUCT_ID,
            $self->getId()
        );
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
