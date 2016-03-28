<?php

namespace Barra\RecipeBundle\Tests\Entity;

use Barra\RecipeBundle\Entity\Cooking;
use PHPUnit_Framework_Error;

class CookingTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN = 'Barra\RecipeBundle\Entity\Cooking';
    const RECIPE_FQDN = 'Barra\RecipeBundle\Entity\Recipe';
    const ID = 222;
    const POSITION = 22;
    const DESCRIPTION = 'demoDescription';

    /** @var  Cooking */
    protected $model;

    /**
     * {@inheritdoc}
     */
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
     *
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
     *
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
        $mock = $this->getMock(self::RECIPE_FQDN);
        $resource = $this->model->setRecipe($mock);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetRecipe
     *
     * @param Cooking $self
     */
    public function testGetRecipe(Cooking $self)
    {
        $this->assertNotNull($self->getRecipe());
    }

    public function testIsRemovable()
    {
        $this->assertTrue($this->model->isRemovable());
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     * @dataProvider providerSetInvalidComplexValues
     *
     * @param string $field
     * @param mixed $value
     */
    public function testSetInvalidComplexValues($field, $value)
    {
        $this->model->{'set' . ucfirst($field)}($value);
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
