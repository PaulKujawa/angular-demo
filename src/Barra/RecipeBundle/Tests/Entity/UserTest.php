<?php

namespace Barra\RecipeBundle\Tests\Entity;

use Barra\RecipeBundle\Entity\Reference;
use Barra\RecipeBundle\Entity\User;

/**
 * Class UserTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RecipeBundle\Tests\Entity
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN = 'Barra\RecipeBundle\Entity\User';
    const ID = 2;

    /** @var  User */
    protected $model;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->model = new User();
    }

    /**
     * Sets protected id field first to test the get function
     */
    public function testGetId()
    {
        $reflected = new \ReflectionClass(self::SELF_FQDN);
        $idField = $reflected->getProperty('id');
        $idField->setAccessible(true);
        $idField->setValue($this->model, self::ID);

        $got = $this->model->getId();
        $this->assertEquals(self::ID, $got);
    }
}
