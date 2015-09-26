<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\BackBundle\Entity\Manufacturer;
use Barra\BackBundle\Entity\Product;
use Barra\BackBundle\Entity\Ingredient;

/**
 * Class ProductTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class ProductTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN          = 'Barra\BackBundle\Entity\Product';
    const INGREDIENT_FQDN    = 'Barra\BackBundle\Entity\Ingredient';
    const MANUFACTURER_FQDN  = 'Barra\BackBundle\Entity\Manufacturer';
    const ID                 = 2;
    const TITLE              = 'demoName';
    const URL                = 'demoUrl';
    const DEMO_INT           = 222;
    const DEMO_DOUBLE        = 222.333;
    const IS_VEGAN           = true;

    /** @var  Product $model */
    protected $model;

    /**
     * Initialises model entity
     */
    public function setUp()
    {
        $this->model = new Product();
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
     * @return Product
     */
    public function addIngredient()
    {
        $mock     = $this->getMock(self::INGREDIENT_FQDN);
        $resource = $this->model->addIngredient($mock);

        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends addIngredient
     * @param Product $self
     * @return Ingredient
     */
    public function getIngredients(Product $self)
    {
        $ingredients = $self->getIngredients();
        $ingredient  = $ingredients[0];

        $this->assertCount(
            1,
            $ingredients
        );

        $mock = $this->getMock(self::INGREDIENT_FQDN);
        $this->assertEquals(
            $mock,
            $ingredient
        );

        return $ingredient;
    }

    /**
     * @test
     * @depends addIngredient
     * @depends getIngredients
     * @param Product $self
     * @param Ingredient  $ingredient
     */
    public function removeIngredient(Product $self, Ingredient $ingredient)
    {
        $resource = $self->removeIngredient($ingredient);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        $this->assertCount(
            0,
            $self->getIngredients()
        );
    }

    /**
     * @test
     * @expectedException PHPUnit_Framework_Error
     */
    public function addInvalidIngredient()
    {
        $this->model->addIngredient(1);
    }

    /**
     * @test
     * @expectedException PHPUnit_Framework_Error
     */
    public function removeInvalidIngredient()
    {
        $this->model->removeIngredient(1);
    }

    /**
     * @test
     * @return Product
     */
    public function setKcal()
    {
        $resource = $this->model->setKcal(self::DEMO_INT);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setKcal
     * @param Product $self
     */
    public function getKcal(Product $self)
    {
        $got = $self->getKcal();
        $this->assertInternalType(
            'int',
            $got
        );

        $this->assertEquals(
            self::DEMO_INT,
            $got
        );
    }

    /**
     * @test
     * @return Product
     */
    public function setGr()
    {
        $resource = $this->model->setGr(self::DEMO_INT);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setGr
     * @param Product $self
     */
    public function getGr(Product $self)
    {
        $got = $self->getGr();
        $this->assertInternalType(
            'int',
            $got
        );

        $this->assertEquals(
            self::DEMO_INT,
            $got
        );
    }

    /**
     * @test
     * @return Product
     */
    public function setProtein()
    {
        $resource = $this->model->setProtein(self::DEMO_DOUBLE);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setProtein
     * @param Product $self
     */
    public function getProtein(Product $self)
    {
        $got = $self->getProtein();
        $this->assertInternalType(
            'double',
            $got
        );

        $this->assertEquals(
            self::DEMO_DOUBLE,
            $got
        );
    }

    /**
     * @test
     * @return Product
     */
    public function setCarbs()
    {
        $resource = $this->model->setCarbs(self::DEMO_DOUBLE);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setCarbs
     * @param Product $self
     */
    public function getCarbs(Product $self)
    {
        $got = $self->getCarbs();
        $this->assertInternalType(
            'double',
            $got
        );

        $this->assertEquals(
            self::DEMO_DOUBLE,
            $got
        );
    }

    /**
     * @test
     * @return Product
     */
    public function setSugar()
    {
        $resource = $this->model->setSugar(self::DEMO_DOUBLE);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setSugar
     * @param Product $self
     */
    public function getSugar(Product $self)
    {
        $got = $self->getSugar();
        $this->assertInternalType(
            'double',
            $got
        );

        $this->assertEquals(
            self::DEMO_DOUBLE,
            $got
        );
    }

    /**
     * @test
     * @return Product
     */
    public function setFat()
    {
        $resource = $this->model->setFat(self::DEMO_DOUBLE);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setFat
     * @param Product $self
     */
    public function getFat(Product $self)
    {
        $got = $self->getFat();
        $this->assertInternalType(
            'double',
            $got
        );

        $this->assertEquals(
            self::DEMO_DOUBLE,
            $got
        );
    }

    /**
     * @test
     * @return Product
     */
    public function setGfat()
    {
        $resource = $this->model->setGfat(self::DEMO_DOUBLE);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setGfat
     * @param Product $self
     */
    public function getGfat(Product $self)
    {
        $got = $self->getGfat();
        $this->assertInternalType(
            'double',
            $got
        );

        $this->assertEquals(
            self::DEMO_DOUBLE,
            $got
        );
    }

    /**
     * @test
     * @return Product
     */
    public function setVegan()
    {
        $resource = $this->model->setVegan(self::IS_VEGAN);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setVegan
     * @param Product $self
     */
    public function getVegan(Product $self)
    {
        $got = $self->getVegan();
        $this->assertInternalType(
            'bool',
            $got
        );

        $this->assertEquals(
            self::IS_VEGAN,
            $got
        );
    }

    /**
     * @test
     */
    public function getRecipes()
    {

        $mock = $this->getMock(self::INGREDIENT_FQDN);
        $mock
            ->expects($this->once())
            ->method('getRecipe')
            ->will($this->returnValue(11))
        ;
        $this->model->addIngredient($mock);
        $got = $this->model->getRecipes();

        $this->assertInternalType(
            'array',
            $got
        );

        $this->assertEquals(
            11,
            $got[0]
        );
    }

    /**
     * @test
     * @return Product
     */
    public function setManufacturer()
    {
        $mock     = $this->getMock(self::MANUFACTURER_FQDN);
        $resource = $this->model->setManufacturer($mock);

        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setManufacturer
     * @param Product $self
     * @return Manufacturer
     */
    public function getManufacturer(Product $self)
    {
        $mock   = $this->getMock(self::MANUFACTURER_FQDN);
        $recipe = $self->getManufacturer();

        $this->assertEquals(
            $mock,
            $recipe
        );

        return $recipe;
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
     */
    public function isRemovableFalse()
    {
        $mock = $this->getMock(self::INGREDIENT_FQDN);
        $this->model->addIngredient($mock);
        $got  = $this->model->isRemovable();

        $this->assertInternalType(
            'bool',
            $got
        );

        $this->assertEquals(
            false,
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
                'manufacturer',
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
                'name',
                1,
            ],
            [
                'vegan',
                1,
            ],
            [
                'kcal',
                1.2,
            ],
            [
                'gr',
                1.2,
            ],
            [
                'protein',
                1,
            ],
            [
                'carbs',
                1,
            ],
            [
                'sugar',
                1,
            ],
            [
                'fat',
                1,
            ],
            [
                'gfat',
                1,
            ],
        ];
    }
}
