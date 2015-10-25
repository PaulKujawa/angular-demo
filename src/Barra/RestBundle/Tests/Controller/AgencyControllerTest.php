<?php

namespace Barra\FrontBundle\Tests\Entity;

use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class AgencyControllerTest
 * @package Barra\FrontBundle\Tests\Entity
 */
class AgencyControllerTest extends WebTestCase
{
    /** @var  Client */
    protected $client;


    /**
     * Login with credentials to receive JWT and attach it as future request http_auth header
     */
    public function setUp()
    {
        $this->loadFixtures([
            'Barra\AdminBundle\DataFixtures\ORM\LoadUserData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadAgencyData',
        ]);

        $this->client = static::createClient();
        $csrfToken    = $this->client
            ->getContainer()
            ->get('form.csrf_provider')
            ->generateCsrfToken('authenticate')
        ;

        $this->client->request(
            'POST',
            '/de/admino/login_check',
            [
                '_username'     => 'demoSA',
                '_password'     => 'testo',
                '_csrf_token'   => $csrfToken,
            ]
        );

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey(
            'token',
            $response
        );

        $this->client = static::createClient(); // without (recent/any) session
        $this->client->setServerParameter('HTTP_Authorization', 'Bearer '.$response['token']);
    }


    public function testNewAction()
    {
        $this->client->request('GET', '/api/agencies/new');
        $this->validateResponse(200, '{"data":{"children":{"name":[],"url":[]}}}');
    }


    public function testGetAction()
    {
        $this->client->request('GET', '/api/agencies/3');
        $expectedJson = '{"data":{"references":[],"id":3,"name":"Agency3","url":"http:\/\/c.com"}}';
        $this->validateResponse(200, $expectedJson);
    }


    public function testCgetAction()
    {
        $this->client->request('GET', '/api/agencies');
        $expectedJson = '{"data":['.
                            '{"references":[],"id":1,"name":"Agency1","url":"http:\/\/a.com"},'.
                            '{"references":[],"id":2,"name":"Agency2","url":"http:\/\/b.com"},'.
                            '{"references":[],"id":3,"name":"Agency3","url":"http:\/\/c.com"}'.
                        ']}';
        $this->validateResponse(200, $expectedJson);
    }


    /**
     * @param null|int      $expectedStatusCode
     * @param null|string   $expectedJSON
     */
    protected function validateResponse($expectedStatusCode = 200, $expectedJSON = null)
    {
        $this->assertEquals(
            $expectedStatusCode,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertEquals(
            $expectedJSON,
            $this->client->getResponse()->getContent()
        );
    }
}