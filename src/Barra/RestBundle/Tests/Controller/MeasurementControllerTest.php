<?php

namespace Barra\RestBundle\Tests\Controller;

use FOS\RestBundle\Util\Codes;
use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class MeasurementControllerTest
 * @package Barra\RestBundle\Tests\Controller
 */
class MeasurementControllerTest extends WebTestCase
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
            'Barra\AdminBundle\DataFixtures\ORM\LoadMeasurementData',
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
        $this->assertArrayHasKey('token', $response);

        $this->client = static::createClient(); // without (recent/any) session
        $this->client->setServerParameter('HTTP_Authorization', 'Bearer '.$response['token']);
    }


    public function testNew()
    {
        $this->client->request('GET', '/api/measurements/new');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"children":{"name":[],"gr":[]}}}');
    }


    public function testGet()
    {
        $this->client->request('GET', '/api/measurements/1');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"gr":1,"id":1,"name":"gr"}}');

        $this->client->request('GET', '/api/measurements/0');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }


    public function testCget()
    {
        $this->client->request('GET', '/api/measurements?limit=2');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":['.
                '{"gr":1,"id":1,"name":"gr"},'.
                '{"gr":15,"id":2,"name":"el"}'.
            ']}'
        );

        $this->client->request('GET', '/api/measurements');
        $this->validateResponse(Codes::HTTP_BAD_REQUEST);
    }


    public function testGetIngredients()
    {
        $this->loadFixtures([
            'Barra\AdminBundle\DataFixtures\ORM\LoadUserData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadManufacturerData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadMeasurementData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadRecipeData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadProductData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadIngredientData',
        ]);

        $this->client->request('GET', '/api/measurements/1/ingredients');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":['.
                '{"id":11,"amount":1,"position":1},'.
                '{"id":12,"amount":2,"position":2},'.
                '{"id":13,"amount":3,"position":3}'.
            ']}'
        );

        $this->client->request('GET', '/api/measurements/0/ingredients');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }


    public function testPost()
    {
        $this->client->request(
            'POST',
            '/api/measurements',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"formMeasurement":{"name":"kg","gr":1000}}'
        );

        $this->validateResponse(Codes::HTTP_CREATED);
        $this->assertStringEndsWith('/api/measurements/4', $this->client->getResponse()->headers->get('Location'));
    }


    public function testPostInvalid()
    {
        $this->client->request(
            'POST',
            '/api/measurements',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{}'
        );
        $this->validateResponse(Codes::HTTP_BAD_REQUEST, '{"data":{"children":{"name":[],"gr":[]}}}');
    }


    public function testPut()
    {
        $this->client->request(
            'PUT',
            '/api/measurements/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"formMeasurement":{"name":"updated","gr":100}}'
        );
        $this->validateResponse(Codes::HTTP_NO_CONTENT);
        $this->assertStringEndsWith('/api/measurements/1', $this->client->getResponse()->headers->get('Location'));

        $this->client->request(
            'PUT',
            '/api/measurements/0',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{}'
        );
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }


    public function testDelete()
    {
        $this->client->request('DELETE', '/api/measurements/1');
        $this->validateResponse(Codes::HTTP_NO_CONTENT);

        $this->client->request('DELETE', '/api/measurements/0');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }


    public function testDeleteInvalid()
    {
        $this->loadFixtures([
            'Barra\AdminBundle\DataFixtures\ORM\LoadUserData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadManufacturerData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadMeasurementData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadRecipeData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadProductData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadIngredientData',
        ]);

        $this->client->request('DELETE', '/api/measurements/1');
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