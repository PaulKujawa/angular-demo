<?php

namespace Barra\RecipeBundle\Tests\Entity;

use Barra\RecipeBundle\Entity\Cooking;

/**
 * Class CookingTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RecipeBundle\Tests\Entity
 */
class CookingTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN     = 'Barra\RecipeBundle\Entity\Cooking';
    const RECIPE_FQDN   = 'Barra\RecipeBundle\Entity\Recipe';
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
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetDescriptionTest
     * @param Cooking $self
     */
    public function testGetDescriptionTest(Cooking $self)
    {
        $this->assertEquals(self::DESCRIPTION, $self->getDescription());
    }

    /**
     * @return Cooking
     */
    public function testSetPosition()
    {
        $resource = $this->model->setPosition(self::POSITION);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetPosition
     * @param Cooking $self
     */
    public function testGetPosition(Cooking $self)
    {
        $this->assertEquals(self::POSITION, $self->getPosition());
    }

    /**
     * @return Cooking
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
     * @param Cooking $self
     */
    public function testGetRecipe(Cooking $self)
    {
        $this->assertNotNull($self->getRecipe());
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
            ->will($this->returnValue(self::ID));

        $this->model->setRecipe($mock);
        $this->model->setPosition(self::POSITION);
        $resource = $this->model->createId();
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testCreateId
     * @param Cooking $self
     */
    public function testGetId(Cooking $self)
    {
        $this->assertEquals(self::ID.self::POSITION, $self->getId());
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
        ];
    }
}
