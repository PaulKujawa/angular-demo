<?php

namespace Barra\RestBundle\Tests\Controller;

use FOS\RestBundle\Util\Codes;
use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class ManufacturerControllerTest
 * @package Barra\RestBundle\Tests\Controller
 */
class ManufacturerControllerTest extends WebTestCase
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
            'Barra\AdminBundle\DataFixtures\ORM\LoadManufacturerData',
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
        $this->client->request('GET', '/api/manufacturers/new');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"children":{"name":[]}}}');
    }


    public function testGetAction()
    {
        $this->client->request('GET', '/api/manufacturers/3');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":{"products":[],"id":3,"name":"Manufacturer3"}}'
        );

        $this->client->request('GET', '/api/manufacturers/-3');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }


    public function testCgetAction()
    {
        $this->client->request('GET', '/api/manufacturers?limit=2');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":['.
                '{"products":[],"id":1,"name":"Manufacturer1"},'.
                '{"products":[],"id":2,"name":"Manufacturer2"}'.
            ']}'
        );

        $this->client->request('GET', '/api/manufacturers');
        $this->validateResponse(Codes::HTTP_BAD_REQUEST);
    }


    public function testPostAction()
    {
        $this->client->request(
            'POST',
            '/api/manufacturers',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"formManufacturer":{"name":"Manufacturer4"}}'
        );

        $this->validateResponse(Codes::HTTP_CREATED);
        $this->assertStringEndsWith(
            '/api/manufacturers/4',
            $this->client->getResponse()->headers->get('Location')
        );
    }


    public function testPutAction()
    {
        $this->client->request(
            'PUT',
            '/api/manufacturers/2',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"formManufacturer":{"name":"updated"}}'
        );

        $this->validateResponse(Codes::HTTP_NO_CONTENT);
        $this->assertStringEndsWith(
            '/api/manufacturers/2',
            $this->client->getResponse()->headers->get('Location')
        );
    }
    
    public function testPutActionNotFound()
    {
        $this->client->request(
            'PUT',
            '/api/manufacturers/4',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"formManufacturer":{"name":"updated"}}'
        );        
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }
    

    public function testPutActionInvalidForm()
    {
        $this->client->request(
            'PUT',
            '/api/manufacturers/2',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"INVALID":{"name":"updated"}}'
        );
        $this->validateResponse(Codes::HTTP_BAD_REQUEST, '{"data":{"children":{"name":[]}}}');
    }


    public function testDeleteAction()
    {
        $this->client->request('DELETE', '/api/manufacturers/3');
        $this->validateResponse(Codes::HTTP_NO_CONTENT);

        $this->client->request('DELETE', '/api/manufacturers/4');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);

        $this->loadFixtures([
            'Barra\AdminBundle\DataFixtures\ORM\LoadUserData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadManufacturerData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadProductData',
        ]);

        $this->client->request('DELETE', '/api/manufacturers/3');
        $this->validateResponse(Codes::HTTP_CONFLICT);
    }


    /**
     * @param int           $expectedStatusCode
     * @param null|string   $expectedJSON
     */
    protected function validateResponse($expectedStatusCode, $expectedJSON = null)
    {
        $this->assertEquals(
            $expectedStatusCode,
            $this->client->getResponse()->getStatusCode()
        );

        if (null !== $expectedJSON) {
            $this->assertEquals(
                $expectedJSON,
                $this->client->getResponse()->getContent()
            );
        }
    }
}