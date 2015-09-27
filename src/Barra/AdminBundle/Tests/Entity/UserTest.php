<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\AdminBundle\Entity\Reference;
use Barra\AdminBundle\Entity\User;

/**
 * Class UserTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN                 = 'Barra\AdminBundle\Entity\User';
    const ID                        = 2;

    /** @var  User $model */
    protected $model;

    /**
     * Initialises model entity
     */
    public function setUp()
    {
        $this->model = new User();
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
}
