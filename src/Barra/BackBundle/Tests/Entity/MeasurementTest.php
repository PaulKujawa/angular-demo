<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\BackBundle\Entity\Measurement;
use Barra\BackBundle\Entity\Ingredient;

/**
 * Class MeasurementTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class MeasurementTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN     = 'Barra\BackBundle\Entity\Measurement';
    const PRODUCT_FQDN  = 'Barra\BackBundle\Entity\Ingredient';
    const ID            = 2;
    const GR            = 22;
    const NAME          = 'demoName';

    /** @var  Measurement $model */
    protected $model;

    /**
     * Initialises model entity
     */
    public function setUp()
    {
        $this->model = new Measurement();
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
     *
     * @return Measurement
     */
    public function setGr()
    {
        $resource = $this->model->setGr(self::GR);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setGr
     * @param Measurement $self
     */
    public function getGr(Measurement $self)
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
     * @test
     * @return Measurement
     */
    public function setNameTest()
    {
        $resource = $this->model->setName(self::NAME);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setNameTest
     * @param Measurement $self
     */
    public function getNameTest(Measurement $self)
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
     * @test
     * @return Measurement
     */
    public function addIngredient()
    {
        $mock     = $this->getMock(self::PRODUCT_FQDN);
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
     * @param Measurement $self
     * @return Ingredient
     */
    public function getIngredients(Measurement $self)
    {
        $ingredients = $self->getIngredients();
        $ingredient  = $ingredients[0];

        $this->assertCount(
            1,
            $ingredients
        );

        $mock = $this->getMock(self::PRODUCT_FQDN);
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
     * @param Measurement  $self
     * @param Ingredient       $ingredient
     */
    public function removeIngredient(Measurement $self, Ingredient $ingredient)
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
                'gr',
                '1',
            ],
        ];
    }
}
