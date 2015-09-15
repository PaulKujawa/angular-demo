<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\FrontBundle\Entity\Cooking;
use Barra\FrontBundle\Entity\Recipe;

/**
 * Class CookingTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class CookingTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN     = 'Barra\FrontBundle\Entity\Cooking';
    const RECIPE_FQDN   = 'Barra\FrontBundle\Entity\Recipe';
    const ID            = 222;
    const POSITION      = 22;
    const DESCRIPTION   = 'demoDescription';

    /** @var  Cooking $model */
    protected $model;

    /**
     * Initialises model entity
     */
    public function setUp()
    {
        $this->model = new Cooking();
    }

    /**
     * @test
     * @return Cooking
     */
    public function setDescriptionTest()
    {
        $resource = $this->model->setDescription(self::DESCRIPTION);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setDescriptionTest
     * @param Cooking $self
     */
    public function getDescriptionTest(Cooking $self)
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
     * @test
     * @return Cooking
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
     * @param Cooking $self
     */
    public function getPosition(Cooking $self)
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
     * @return Cooking
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
     * @param Cooking $self
     * @return Recipe
     */
    public function getRecipe(Cooking $self)
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
     * @depends setPosition
     * @depends setRecipe
     * @return Cooking
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
        $this->model->setPosition(self::POSITION);

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
     * @param Cooking $self
     */
    public function getId(Cooking $self)
    {
        $this->assertEquals(
            self::ID.self::POSITION,
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