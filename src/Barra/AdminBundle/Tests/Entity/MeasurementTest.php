<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\AdminBundle\Entity\Measurement;
use Barra\AdminBundle\Entity\Ingredient;

/**
 * Class MeasurementTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
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
     *
     * @return Measurement
     */
    public function testSetGr()
    {
        $resource = $this->model->setGr(self::GR);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testSetGr
     * @param Measurement $self
     */
    public function testGetGr(Measurement $self)
    {
        $got = $self->getGr();
        $this->assertInternalType(
            'int',
            $got
        );

        $this->assertEquals(
            self::GR,
            $got
        );
    }


    /**
     * @return Measurement
     */
    public function testSetName()
    {
        $resource = $this->model->setName(self::NAME);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testSetName
     * @param Measurement $self
     */
    public function testGetName(Measurement $self)
    {
        $got = $self->getName();
        $this->assertInternalType(
            'string',
            $got
        );

        $this->assertEquals(
            self::NAME,
            $got
        );
    }


    /**
     * @return Measurement
     */
    public function testAddIngredient()
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
     * @depends testAddIngredient
     * @param Measurement $self
     * @return Ingredient
     */
    public function testGetIngredients(Measurement $self)
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
     * @depends testAddIngredient
     * @depends testGetIngredients
     * @param Measurement  $self
     * @param Ingredient       $ingredient
     */
    public function testRemoveIngredient(Measurement $self, Ingredient $ingredient)
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


    public function testIsRemovableFalse()
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
                'name',
                1,
            ],
            [
                'gr',
                '1',
            ],
        ];
    }
}
