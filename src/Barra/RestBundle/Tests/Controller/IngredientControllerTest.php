<?php

namespace Barra\RestBundle\Tests\Controller;

use FOS\RestBundle\Util\Codes;
use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class IngredientControllerTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Tests\Controller
 */
class IngredientControllerTest extends WebTestCase
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
            'Barra\AdminBundle\DataFixtures\ORM\LoadMeasurementData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadRecipeData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadProductData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadIngredientData',
        ]);

        $this->client = static::createClient();
        $csrfToken    = $this->client
            ->getContainer()
            ->get('form.csrf_provider')
            ->generateCsrfToken('authenticate');

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
        $this->client->request('GET', '/en/api/ingredients/new');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":{"children":{"amount":[],"measurement":[],"product":[],"recipe":[]}}}'
        );
    }

    public function testGet()
    {
        $this->client->request('GET', '/en/api/ingredients/11');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"id":11,"amount":1,"position":1}}');

        $this->client->request('GET', '/en/api/ingredients/0');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testCget()
    {
        $this->client->request('GET', '/en/api/ingredients?limit=2');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":['.
                '{"id":11,"amount":1,"position":1},'.
                '{"id":12,"amount":2,"position":2}'.
            ']}'
        );

        $this->client->request('GET', '/en/api/ingredients');
        $this->validateResponse(Codes::HTTP_BAD_REQUEST);
    }

    public function testGetProduct()
    {
        $this->client->request('GET', '/en/api/ingredients/11/product');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":{'.
                '"vegan":false,"gr":1,"kcal":1,"protein":1,"carbs":1,'.
                '"sugar":1,"fat":1,"gfat":1,"id":1,"name":"Product1"'.
            '}}'
        );

        $this->client->request('GET', '/en/api/ingredients/0/product');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testGetMeasurement()
    {
        $this->client->request('GET', '/en/api/ingredients/11/measurement');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"gr":1,"id":1,"name":"gr"}}');

        $this->client->request('GET', '/en/api/ingredients/0/measurement');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testGetRecipe()
    {
        $this->client->request('GET', '/en/api/ingredients/11/recipe');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"id":1,"name":"Recipe1"}}');

        $this->client->request('GET', '/en/api/ingredients/0/recipe');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testPost()
    {
        $this->client->request(
            'POST',
            '/en/api/ingredients',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"formIngredient":{"amount":1,"measurement":1,"product":4,"recipe":1}}'
        );

        $this->validateResponse(Codes::HTTP_CREATED);
        $this->assertStringEndsWith('/en/api/ingredients/14', $this->client->getResponse()->headers->get('Location'));
    }

    public function testPostInvalid()
    {
        $this->client->request(
            'POST',
            '/en/api/ingredients',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{}'
        );
        $this->validateResponse(
            Codes::HTTP_BAD_REQUEST,
            '{"data":{"children":{"amount":[],"measurement":[],"product":[],"recipe":[]}}}'
        );

        $this->client->request(
            'POST',
            '/en/api/ingredients',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"formIngredient":{"recipe":0}}'
        );
        $this->validateResponse(
            Codes::HTTP_BAD_REQUEST,
            '{"data":{"children":{"amount":[],"measurement":[],"product":[],"recipe":[]}}}'
        );
    }

    public function testPut()
    {
        $this->client->request(
            'PUT',
            '/en/api/ingredients/11',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"formIngredient":{"amount":1,"measurement":1,"product":4,"recipe":1}}'
        );
        $this->validateResponse(Codes::HTTP_NO_CONTENT);
        $this->assertStringEndsWith('/en/api/ingredients/14', $this->client->getResponse()->headers->get('Location'));

        $this->client->request(
            'PUT',
            '/en/api/ingredients/0',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{}'
        );
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testDelete()
    {
        $this->client->request('DELETE', '/en/api/ingredients/11');
        $this->validateResponse(Codes::HTTP_NO_CONTENT);

        $this->client->request('DELETE', '/en/api/ingredients/0');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
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