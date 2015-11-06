<?php

namespace Barra\FrontBundle\Tests\Entity;

use FOS\RestBundle\Util\Codes;
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
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"children":{"name":[],"url":[]}}}');
    }


    public function testGetAction()
    {
        $this->client->request('GET', '/api/agencies/3');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":{"references":[],"id":3,"name":"Agency3","url":"http:\/\/c.com"}}'
        );

        $this->client->request('GET', '/api/agencies/-3');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }


    public function testCgetAction()
    {
        $this->client->request('GET', '/api/agencies?limit=2');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":['.
                '{"references":[],"id":1,"name":"Agency1","url":"http:\/\/a.com"},'.
                '{"references":[],"id":2,"name":"Agency2","url":"http:\/\/b.com"}'.
            ']}'
        );

        $this->client->request('GET', '/api/agencies');
        $this->validateResponse(Codes::HTTP_BAD_REQUEST);
    }


    public function testPostAction()
    {
        $this->client->request(
            'POST',
            '/api/agencies',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"formAgency":{"name":"Agency4","url":"http://d.de"}}'
        );

        $this->validateResponse(Codes::HTTP_CREATED);
        $this->assertStringEndsWith(
            '/api/agencies/4',
            $this->client->getResponse()->headers->get('Location')
        );
    }


    public function testPutAction()
    {
        $this->client->request(
            'PUT',
            '/api/agencies/2',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"formAgency":{"name":"updated","url":"http://updated.de"}}'
        );

        $this->validateResponse(Codes::HTTP_NO_CONTENT);
        $this->assertStringEndsWith(
            '/api/agencies/2',
            $this->client->getResponse()->headers->get('Location')
        );
    }
    
    public function testPutActionNotFound()
    {
        $this->client->request(
            'PUT',
            '/api/agencies/4',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"formAgency":{"name":"updated","url":"http://updated.de"}}'
        );        
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }
    

    public function testPutActionInvalidForm()
    {
        $this->client->request(
            'PUT',
            '/api/agencies/2',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"INVALID":{"name":"updated","url":"http://updated.de"}}'
        );
        $this->validateResponse(Codes::HTTP_BAD_REQUEST, '{"data":{"children":{"name":[],"url":[]}}}');
    }


    public function testDeleteAction()
    {
        $this->client->request('DELETE', '/api/agencies/3');
        $this->validateResponse(Codes::HTTP_NO_CONTENT);

        $this->client->request('DELETE', '/api/agencies/4');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);

        $this->loadFixtures([
            'Barra\AdminBundle\DataFixtures\ORM\LoadUserData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadAgencyData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadTechniqueData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadReferenceData',
        ]);

        $this->client->request('DELETE', '/api/agencies/3');
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