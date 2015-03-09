<?php

namespace Barra\RestBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use FOS\RestBundle\Util\Codes;
use Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData;

class RecipeControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->auth = array(
            'PHP_AUTH_USER' => 'user',
            'PHP_AUTH_PW' => 'userpass',
        );

        $this->client = static::createClient(array() /*, $this->auth*/);
    }


    /**
     * get one + ID check
     */
    public function testGetRecipe()
    {
        $this->loadFixtures(array('Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData'));
        $recipes = LoadRecipeData::$members;
        $recipe = array_pop($recipes);

        $this->client->request('GET', '/api/recipes/'.$recipe->getId(), array('ACCEPT' => 'application/json'));
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response);

        $content = json_decode($response->getContent(), true);
        $this->assertEquals($content['recipe']['id'], $recipe->getId());
    }


    /**
     * request one with invalid/unused ID
     */
    public function testGetRecipe404()
    {
        $this->loadFixtures(array('Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData'));
        $recipes = LoadRecipeData::$members;

        $this->client->request('GET', '/api/recipes/-1', array('ACCEPT' => 'application/json'));
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response, Codes::HTTP_NOT_FOUND, false);
    }


    /**
     * get all
     */
    public function testGetRecipes()
    {
        $this->loadFixtures(array('Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData'));
        $recipes = LoadRecipeData::$members; // 3 entities

        $this->client->request('GET', '/api/recipes', array('ACCEPT' => 'application/json'));
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response);

        $content = json_decode($response->getContent(), true);
        $this->assertEquals(3, count($content['recipes']));
    }


    /**
     * get some with default values + ID checks
     */
    public function testGetRecipesLimitedDefault()
    {
        $this->loadFixtures(array('Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData'));
        $recipes = LoadRecipeData::$members; // 3 entities

        // based on default values: offset=0 & limit=2
        $this->client->request('GET', '/api/recipes/limited', array('ACCEPT' => 'application/json'));
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response);

        array_pop($recipes);
        $content = json_decode($response->getContent(), true);
        $this->assertEquals(2, count($content['recipes']));
        $this->assertEquals($content['recipes'][1]['id'], array_pop($recipes)->getId());
        $this->assertEquals($content['recipes'][0]['id'], array_pop($recipes)->getId());
    }


    /**
     * get some with custom offset & limit + ID check
     */
    public function testGetRecipesLimitedOffset()
    {
        $this->loadFixtures(array('Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData'));
        $recipes = LoadRecipeData::$members; // 3 entities

        // one entity in the middle
        $this->client->request('GET', '/api/recipes/limited?offset=1&limit=1', array('ACCEPT' => 'application/json'));
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response);

        array_pop($recipes);
        $content = json_decode($response->getContent(), true);
        $this->assertEquals(1, count($content['recipes']));
        $this->assertEquals($content['recipes'][0]['id'], array_pop($recipes)->getId());
    }


    /**
     * get some with invalid offset & limit | limit > number of entities
     */
    public function testGetRecipesLimitedInvalid()
    {
        $this->loadFixtures(array('Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData'));
        $recipes = LoadRecipeData::$members; // 3 entities

        // invalid will be ignored
        $this->client->request('GET', '/api/recipes/limited?offset=-1&limit=-1', array('ACCEPT' => 'application/json'));
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response);

        array_pop($recipes);
        $content = json_decode($response->getContent(), true);
        $this->assertEquals(2, count($content['recipes']));
        $this->assertEquals($content['recipes'][1]['id'], array_pop($recipes)->getId());
        $this->assertEquals($content['recipes'][0]['id'], array_pop($recipes)->getId());


        // limit > number of entities
        $this->client->request('GET', '/api/recipes/limited?limit=8', array('ACCEPT' => 'application/json'));
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response);

        $content = json_decode($response->getContent(), true);
        $this->assertEquals(3, count($content['recipes']));
    }


    /**
     * post one
     */
    public function testPostRecipe()
    {
        $this->client->request('POST', '/api/recipes', array(), array(),
            array('CONTENT_TYPE' => 'application/json', 'Accept' => 'application/json'),
            '{"formRecipe":{"name":"testRecipe2"}}'
        );
        $this->assertJsonResponse($this->client->getResponse(), Codes::HTTP_CREATED, false);
    }


    /**
     * post duplicate one for doctrine exception
     */
    public function testPostRecipeUnprocessable()
    {
        $this->client->request('POST', '/api/recipes', array(), array(),
            array('CONTENT_TYPE' => 'application/json', 'Accept' => 'application/json'),
            '{"formRecipe":{"name":"testRecipe2"}}'
        );
        $this->assertJsonResponse($this->client->getResponse(), Codes::HTTP_UNPROCESSABLE_ENTITY);
    }


    /**
     * post invalid
     */
    public function testPostRecipeInvalidForm()
    {
        $this->client->request('POST', '/api/recipes', array(), array(),
            array('CONTENT_TYPE' => 'application/json', 'Accept' => 'application/json'),
            '{"name":"testRecipe"}'
        );
        $this->assertJsonResponse($this->client->getResponse(), Codes::HTTP_BAD_REQUEST, false);
    }

    /**
     * put & $response->headers->get('location') for url
     */
    public function testPutRecipe()
    {
        $this->loadFixtures(array('Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData'));
        $recipes = LoadRecipeData::$members;
        $recipe = array_pop($recipes);


        $this->client->request('PUT', '/api/recipes/'.$recipe->getId(), array(), array(),
            array('CONTENT_TYPE' => 'application/json', 'Accept' => 'application/json'),
            '{"formRecipe":{"name":"changedName"}}'
        );
        $this->assertJsonResponse($this->client->getResponse(), Codes::HTTP_NO_CONTENT, false);
    }


    /**
     * put invalid form
     */
    public function testPutRecipeInvalidForm()
    {
        $this->loadFixtures(array('Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData'));
        $recipes = LoadRecipeData::$members;
        $recipe = array_pop($recipes);

        $this->client->request('PUT', '/api/recipes/'.$recipe->getId(), array(), array(),
            array('CONTENT_TYPE' => 'application/json', 'Accept' => 'application/json'),
            '{"name":"fixtureRecipe1"}'
        );
        $this->assertJsonResponse($this->client->getResponse(), Codes::HTTP_BAD_REQUEST);
    }


    /**
     * delete one
     */
    public function testDeleteRecipe()
    {
        $this->loadFixtures(array('Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData'));
        $recipes = LoadRecipeData::$members;
        $recipe = array_pop($recipes);

        $this->client->request('DELETE', '/api/recipes/'. $recipe->getId());
        $this->assertJsonResponse($this->client->getResponse(), Codes::HTTP_NO_CONTENT, false);
    }


    /**
     * delete an not existing one
     */
    public function testDeleteRecipe404()
    {
        $this->loadFixtures(array('Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData'));
        $recipes = LoadRecipeData::$members;
        $recipe = array_pop($recipes);

        $this->client->request('DELETE', '/api/recipes/'. ($recipe->getId()+1) );
        $this->assertJsonResponse($this->client->getResponse(), Codes::HTTP_NOT_FOUND, false);
    }


    /**
     * checks status code and returned JSON object if there is one returned
     * @param $response
     * @param int $statusCode
     * @param bool $checkValidJson
     */
    protected function assertJsonResponse($response, $statusCode = Codes::HTTP_OK, $checkValidJson = true)
    {
        $this->assertEquals($statusCode, $response->getStatusCode(), $response->getContent());

        if ($checkValidJson) {
            $this->assertTrue($response->headers->contains('content-type', 'application/json'), $response->headers);

            $decode = json_decode($response->getContent());
            $this->assertTrue(($decode != null && $decode != false), 'is response valid json: [' . $response->getContent() . ']');
        }
    }
}