<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\BackBundle\Entity\Ingredient;
use Barra\BackBundle\Entity\Measurement;
use Barra\BackBundle\Entity\Product;
use Barra\BackBundle\Entity\Recipe;

/**
 * Class IngredientTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class IngredientTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN         = 'Barra\BackBundle\Entity\Ingredient';
    const RECIPE_FQDN       = 'Barra\BackBundle\Entity\Recipe';
    const PRODUCT_FQDN      = 'Barra\BackBundle\Entity\Product';
    const MEASUREMENT_FQDN  = 'Barra\BackBundle\Entity\Measurement';
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
        $mock     = $this->getMock(self::RECIPE_FQDN);
        $resource = $this->model->setRecipe($mock);

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
     */
    public function getRecipe(Ingredient $self)
    {
        $mock   = $this->getMock(self::RECIPE_FQDN);
        $recipe = $self->getRecipe();

        $this->assertEquals(
            $mock,
            $recipe
        );
    }

    /**
     * @test
     * @return Ingredient
     */
    public function setProduct()
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
     * @test
     * @depends setProduct
     * @param Ingredient $self
     */
    public function getProduct(Ingredient $self)
    {
        $mock    = $this->getMock(self::PRODUCT_FQDN);
        $product = $self->getProduct();

        $this->assertEquals(
            $mock,
            $product
        );
    }

    /**
     * @test
     * @return Ingredient
     */
    public function setMeasurement()
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
     * @test
     * @depends setMeasurement
     * @param Ingredient $self
     */
    public function getMeasurement(Ingredient $self)
    {
        $mock        = $this->getMock(self::MEASUREMENT_FQDN);
        $measurement = $self->getMeasurement();

        $this->assertEquals(
            $mock,
            $measurement
        );
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
