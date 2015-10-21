<?php

namespace Barra\FrontBundle\Tests\Entity;

use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use Barra\AdminBundle\DataFixtures\ORM\LoadAgencyData;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class AgencyControllerTest
 * @package Barra\FrontBundle\Tests\Entity
 */
class AgencyControllerTest extends WebTestCase
{
    /** @var  Client */
    protected $client;

    public function setUp()
    {
        $this->client = static::makeClient(true);
    }


    /**
     * @test
     */
    public function newJSON()
    {
        $this->client->request('GET', '/api/agencies/new');

//        $this->assertEquals(
//            200,
//            $this->client->getResponse()->getStatusCode()
//        );




//        $this->assertEquals(
//            '{"children":{"title":[],"body":[]}}',
//            $this->client->getResponse()->getContent(),
//            $this->client->getResponse()->getContent()
//        );
    }
}