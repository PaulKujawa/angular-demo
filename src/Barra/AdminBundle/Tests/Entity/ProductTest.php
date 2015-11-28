<?php

namespace Barra\AdminBundle\Tests\Entity;

use Barra\AdminBundle\Entity\Manufacturer;
use Barra\AdminBundle\Entity\Product;
use Barra\AdminBundle\Entity\Ingredient;

/**
 * Class ProductTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Tests\Entity
 */
class ProductTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN          = 'Barra\AdminBundle\Entity\Product';
    const INGREDIENT_FQDN    = 'Barra\AdminBundle\Entity\Ingredient';
    const MANUFACTURER_FQDN  = 'Barra\AdminBundle\Entity\Manufacturer';
    const ID                 = 2;
    const TITLE              = 'demoName';
    const URL                = 'demoUrl';
    const DEMO_INT           = 222;
    const DEMO_DOUBLE        = 222.333;
    const IS_VEGAN           = true;

    /** @var  Product */
    protected $model;

    public function setUp()
    {
        $this->model = new Product();
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
     * @return Product
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
     * @param Product $self
     * @return Ingredient
     */
    public function testGetIngredients(Product $self)
    {
        $ingredients = $self->getIngredients();
        $this->assertCount(1, $ingredients);
        $ingredient  = $ingredients[0];

        return $ingredient;
    }

    /**
     * @depends testAddIngredient
     * @depends testGetIngredients
     * @param Product $self
     * @param Ingredient  $ingredient
     */
    public function testRemoveIngredient(Product $self, Ingredient $ingredient)
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

    /**
     * @return Product
     */
    public function testSetKcal()
    {
        $resource = $this->model->setKcal(self::DEMO_INT);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetKcal
     * @param Product $self
     */
    public function testGetKcal(Product $self)
    {
        $this->assertEquals(self::DEMO_INT, $self->getKcal());
    }

    /**
     * @return Product
     */
    public function testSetGr()
    {
        $resource = $this->model->setGr(self::DEMO_INT);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetGr
     * @param Product $self
     */
    public function testGetGr(Product $self)
    {
        $this->assertEquals(self::DEMO_INT, $self->getGr());
    }

    /**
     * @return Product
     */
    public function testSetProtein()
    {
        $resource = $this->model->setProtein(self::DEMO_DOUBLE);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetProtein
     * @param Product $self
     */
    public function testGetProtein(Product $self)
    {
        $this->assertEquals(self::DEMO_DOUBLE, $self->getProtein());
    }

    /**
     * @return Product
     */
    public function testSetCarbs()
    {
        $resource = $this->model->setCarbs(self::DEMO_DOUBLE);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetCarbs
     * @param Product $self
     */
    public function testGetCarbs(Product $self)
    {
        $this->assertEquals(self::DEMO_DOUBLE, $self->getCarbs());
    }

    /**
     * @return Product
     */
    public function testSetSugar()
    {
        $resource = $this->model->setSugar(self::DEMO_DOUBLE);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetSugar
     * @param Product $self
     */
    public function testGetSugar(Product $self)
    {
        $this->assertEquals(self::DEMO_DOUBLE, $self->getSugar());
    }

    /**
     * @return Product
     */
    public function testSetFat()
    {
        $resource = $this->model->setFat(self::DEMO_DOUBLE);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetFat
     * @param Product $self
     */
    public function testGetFat(Product $self)
    {
        $this->assertEquals(self::DEMO_DOUBLE, $self->getFat());
    }

    /**
     * @return Product
     */
    public function testSetGfat()
    {
        $resource = $this->model->setGfat(self::DEMO_DOUBLE);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetGfat
     * @param Product $self
     */
    public function testGetGfat(Product $self)
    {
        $this->assertEquals(self::DEMO_DOUBLE, $self->getGfat());
    }

    /**
     * @return Product
     */
    public function testSetVegan()
    {
        $resource = $this->model->setVegan(self::IS_VEGAN);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetVegan
     * @param Product $self
     */
    public function testGetVegan(Product $self)
    {
        $this->assertEquals(self::IS_VEGAN, $self->getVegan());
    }

    public function testGetRecipes()
    {

        $mock = $this->getMock(self::INGREDIENT_FQDN);
        $mock
            ->expects($this->once())
            ->method('getRecipe')
            ->will($this->returnValue(11));

        $this->model->addIngredient($mock);

        $got = $this->model->getRecipes();
        $this->assertEquals(11, $got[0]);
    }

    /**
     * @return Product
     */
    public function testSetManufacturer()
    {
        $mock     = $this->getMock(self::MANUFACTURER_FQDN);
        $resource = $this->model->setManufacturer($mock);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetManufacturer
     * @param Product $self
     */
    public function testGetManufacturer(Product $self)
    {
        $this->assertNotNull($self->getManufacturer());
    }

    public function testIsRemovable()
    {
        $this->assertTrue($this->model->isRemovable());

        $mock = $this->getMock(self::INGREDIENT_FQDN);
        $this->model->addIngredient($mock);
        $this->assertFalse($this->model->isRemovable());
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
                'manufacturer',
                1,
            ],
        ];
    }
}
