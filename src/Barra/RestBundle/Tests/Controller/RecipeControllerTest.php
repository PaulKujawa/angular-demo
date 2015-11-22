<?php

namespace Barra\RestBundle\Tests\Controller;

use Barra\AdminBundle\DataFixtures\ORM\LoadPhotoData;
use Barra\AdminBundle\Entity\Photo;
use FOS\RestBundle\Util\Codes;
use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class RecipeControllerTest
 * @package Barra\RestBundle\Tests\Controller
 */
class RecipeControllerTest extends WebTestCase
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
            'Barra\AdminBundle\DataFixtures\ORM\LoadRecipeData',
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
        $this->client->request('GET', '/api/recipes/new');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"children":{"name":[]}}}');
    }


    public function testGet()
    {
        $this->client->request('GET', '/api/recipes/1');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"id":1,"name":"Recipe1"}}');

        $this->client->request('GET', '/api/recipes/0');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }


    public function testCget()
    {
        $this->client->request('GET', '/api/recipes?limit=2');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":['.
                '{"id":1,"name":"Recipe1"},'.
                '{"id":2,"name":"Recipe2"}'.
            ']}'
        );

        $this->client->request('GET', '/api/recipes');
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

        $this->client->request('GET', '/api/recipes/1/ingredients');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":['.
                '{"id":11,"amount":1,"position":1},'.
                '{"id":12,"amount":2,"position":2},'.
                '{"id":13,"amount":3,"position":3}'.
            ']}'
        );

        $this->client->request('GET', '/api/recipes/0/ingredients');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }


    public function testGetCookings()
    {
        $this->loadFixtures([
            'Barra\AdminBundle\DataFixtures\ORM\LoadUserData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadRecipeData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadCookingData',
        ]);

        $this->client->request('GET', '/api/recipes/1/cookings');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":['.
                '{"id":11,"description":"1th step","position":1},'.
                '{"id":12,"description":"2th step","position":2},'.
                '{"id":13,"description":"3th step","position":3}'.
            ']}'
        );

        $this->client->request('GET', '/api/recipes/0/cookings');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }


    /** TODO deactivated, since $members is empty */
    public function GetPhotos()
    {
        $this->loadFixtures([
            'Barra\AdminBundle\DataFixtures\ORM\LoadUserData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadRecipeData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadPhotoData',
        ]);

        $this->client->request('GET', '/api/recipes/1/photos');

        /** @var Photo $photo */
        $photo = LoadPhotoData::$members[0];

        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":['.
                '{"id":3,"filename":"'.$photo->getFilename().'","size":145263,"name":"Photo3"}'.
            ']}'
        );
        unlink($photo->getAbsolutePathWithFilename());

        $this->client->request('GET', '/api/recipes/0/photos');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }


    public function testPost()
    {
        $this->client->request(
            'POST',
            '/api/recipes',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"formRecipe":{"name":"Recipe4"}}'
        );

        $this->validateResponse(Codes::HTTP_CREATED);
        $this->assertStringEndsWith('/api/recipes/4', $this->client->getResponse()->headers->get('Location'));
    }


    public function testPostInvalid()
    {
        $this->client->request(
            'POST',
            '/api/recipes',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{}'
        );
        $this->validateResponse(Codes::HTTP_BAD_REQUEST, '{"data":{"children":{"name":[]}}}');
    }


    public function testPut()
    {
        $this->client->request(
            'PUT',
            '/api/recipes/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"formRecipe":{"name":"updated"}}'
        );
        $this->validateResponse(Codes::HTTP_NO_CONTENT);
        $this->assertStringEndsWith('/api/recipes/1', $this->client->getResponse()->headers->get('Location'));

        $this->client->request(
            'PUT',
            '/api/recipes/0',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{}'
        );
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }


    public function testDelete()
    {
        $this->client->request('DELETE', '/api/recipes/1');
        $this->validateResponse(Codes::HTTP_NO_CONTENT);

        $this->client->request('DELETE', '/api/recipes/0');
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