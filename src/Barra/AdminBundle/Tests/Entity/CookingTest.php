<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\AdminBundle\Entity\Cooking;
use Barra\AdminBundle\Entity\Recipe;

/**
 * Class CookingTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class CookingTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN     = 'Barra\AdminBundle\Entity\Cooking';
    const RECIPE_FQDN   = 'Barra\AdminBundle\Entity\Recipe';
    const ID            = 222;
    const POSITION      = 22;
    const DESCRIPTION   = 'demoDescription';


    /** @var  Cooking */
    protected $model;


    public function setUp()
    {
        $this->model = new Cooking();
    }


    /**
     * @return Cooking
     */
    public function testSetDescriptionTest()
    {
        $resource = $this->model->setDescription(self::DESCRIPTION);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testSetDescriptionTest
     * @param Cooking $self
     */
    public function testGetDescriptionTest(Cooking $self)
    {
        $got = $self->getDescription();
        $this->assertInternalType(
            'string',
            $got
        );

        $this->assertEquals(
            self::DESCRIPTION,
            $got
        );
    }


    /**
     * @return Cooking
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
     * @param Cooking $self
     */
    public function testGetPosition(Cooking $self)
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
     * @return Cooking
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
     * @param Cooking $self
     */
    public function testGetRecipe(Cooking $self)
    {
        $mock   = $this->getMock(self::RECIPE_FQDN);
        $recipe = $self->getRecipe();

        $this->assertEquals(
            $mock,
            $recipe
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
     * @depends testSetPosition
     * @depends testSetRecipe
     * @return Cooking
     */
    public function testCreateId()
    {
        $mock = $this->getMock(self::RECIPE_FQDN);
        $mock
            ->expects($this->exactly(2))
            ->method('getId')
            ->will($this->returnValue(self::ID))
        ;

        $this->model->setRecipe($mock);
        $this->model->setPosition(self::POSITION);
        $resource = $this->model->createId();

        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testCreateId
     * @param Cooking $self
     */
    public function testGetId(Cooking $self)
    {
        $this->assertEquals(
            self::ID.self::POSITION,
            $self->getId()
        );
    }


    /**
     */
    public function testisRemovableTrue()
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
                'description',
                1,
            ],
            [
                'position',
                '1',
            ],
        ];
    }
}
