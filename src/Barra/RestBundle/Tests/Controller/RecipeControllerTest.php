<?php
//
//namespace Barra\RestBundle\Tests\Controller;
//
//use FOS\RestBundle\Util\Codes;
//use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
//use Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData;
//use Barra\FrontBundle\DataFixtures\ORM\LoadUserData;
//
//
//class RecipeControllerTest extends WebTestCase
//{
//    public function setUp()
//    {
//        $this->loadFixtures(['Barra\FrontBundle\DataFixtures\ORM\LoadUserData']);
//        $users = LoadUserData::$members;
//        array_pop($users);
//        $demoAdmin = array_pop($users);
//
//        $this->loginAs($demoAdmin, "api"); // configured in config_test.yml
//        $this->client = static::makeClient(true);
//    }
//
//
//    /**
//     * get the form to use for submits
//     */
//    public function testNew()
//    {
//        $this->client->request('GET', '/api/recipes/new', ['ACCEPT' => 'application/json']);
//        $response = $this->client->getResponse();
//        $this->assertJsonResponse($response);
//    }
//
//
//    /**
//     * get one
//     */
//    public function testGetRecipe()
//    {
//        $this->loadFixtures(['Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData']);
//        $recipes = LoadRecipeData::$members;
//        $recipe = array_pop($recipes);
//
//        $this->client->request('GET', '/api/recipes/'.$recipe->getId(), ['ACCEPT' => 'application/json']);
//        $response = $this->client->getResponse();
//        $this->assertJsonResponse($response);
//
//        $content = json_decode($response->getContent(), true);
//        $this->assertEquals($content['data']['id'], $recipe->getId());
//    }
//
//
//    /**
//     * request one with invalid ID
//     */
//    public function testGet404()
//    {
//        $this->loadFixtures(['Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData']);
//        $recipes = LoadRecipeData::$members;
//
//        $this->client->request('GET', '/api/recipes/-1', ['ACCEPT' => 'application/json']);
//        $response = $this->client->getResponse();
//        $this->assertJsonResponse($response, Codes::HTTP_NOT_FOUND, false);
//    }
//
//
//    /**
//     * get some with via default offset & limit
//     */
//    public function testGetRecipes()
//    {
//        $this->loadFixtures(['Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData']);
//        $recipes = LoadRecipeData::$members; // 3 entities
//
//        $this->client->request('GET', '/api/recipes', ['ACCEPT' => 'application/json']);
//        $response = $this->client->getResponse();
//        $this->assertJsonResponse($response);
//
//        array_pop($recipes);
//        $content = json_decode($response->getContent(), true);
//        $this->assertEquals(2, count($content['data']));
//        $this->assertEquals($content['data'][1]['id'], array_pop($recipes)->getId());
//        $this->assertEquals($content['data'][0]['id'], array_pop($recipes)->getId());
//    }
//
//
//    /**
//     * get some with custom offset & limit
//     */
//    public function testGetOffset()
//    {
//        $this->loadFixtures(['Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData']);
//        $recipes = LoadRecipeData::$members; // 3 entities
//
//        // one entity in the middle
//        $this->client->request('GET', '/api/recipes?offset=1&limit=1&order_by=id&order=DESC', ['ACCEPT' => 'application/json']);
//        $response = $this->client->getResponse();
//        $this->assertJsonResponse($response);
//
//        array_pop($recipes);
//        $content = json_decode($response->getContent(), true);
//        $this->assertEquals(1, count($content['data']));
//        $this->assertEquals($content['data'][0]['id'], array_pop($recipes)->getId());
//    }
//
//
//    /**
//     * get some with invalid offset & limit
//     */
//    public function testGetNegativeParams()
//    {
//        $this->loadFixtures(['Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData']);
//        $recipes = LoadRecipeData::$members; // 3 entities
//
//        // negative numbers will be ignored
//        $this->client->request('GET', '/api/recipes?offset=-1&limit=-1', ['ACCEPT' => 'application/json']);
//        $response = $this->client->getResponse();
//        $this->assertJsonResponse($response);
//
//        // based on default values: offset=0 & limit=2
//        array_pop($recipes);
//        $content = json_decode($response->getContent(), true);
//        $this->assertEquals(2, count($content['data']));
//        $this->assertEquals($content['data'][1]['id'], array_pop($recipes)->getId());
//        $this->assertEquals($content['data'][0]['id'], array_pop($recipes)->getId());
//    }
//
//
//    /**
//     * get some with limit > number of entities
//     */
//    public function testGetLimitTooHigh()
//    {
//        $this->loadFixtures(['Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData']);
//        $this->client->request('GET', '/api/recipes?limit=8', ['ACCEPT' => 'application/json']);
//        $response = $this->client->getResponse();
//        $this->assertJsonResponse($response);
//
//        $content = json_decode($response->getContent(), true);
//        $this->assertEquals(3, count($content['data']));
//    }
//
//
//    /**
//     * create one via post
//     */
//    public function testPost()
//    {
//        $this->loadFixtures(['Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData']);
//        $this->client->request('POST', '/api/recipes', [], [], [
//                'CONTENT_TYPE' => 'application/json',
//                'Accept' => 'application/json',
//            ],
//            '{"formRecipe":{"name":"testRecipe"}}'
//        );
//        $this->assertJsonResponse($this->client->getResponse(), Codes::HTTP_CREATED, false);
//    }
//
//
//    /**
//     * invalid creation via duplicate post
//     */
//    public function testPostDuplicate()
//    {
//        $this->loadFixtures(['Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData']);
//        $this->client->request('POST', '/api/recipes', [], [], [
//                'CONTENT_TYPE' => 'application/json',
//                'Accept' => 'application/json',
//            ],
//            '{"formRecipe":{"name":"fixRecipe2"}}'
//        );
//        $this->assertJsonResponse($this->client->getResponse(), Codes::HTTP_UNPROCESSABLE_ENTITY);
//    }
//
//
//    /**
//     * invalid post owing to invalid form
//     */
//    public function testPostInvalid()
//    {
//        $this->loadFixtures(['Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData']);
//        $this->client->request('POST', '/api/recipes', [], [], [
//                'CONTENT_TYPE' => 'application/json',
//                'Accept' => 'application/json',
//            ],
//            '{"name":"testRecipe"}'
//        );
//        $this->assertJsonResponse($this->client->getResponse(), Codes::HTTP_BAD_REQUEST, false);
//    }
//
//
//    /**
//     * PUT for updating an existing one
//     * for url look at $response->headers->get('location')
//     */
//    public function testPutUpdate()
//    {
//        $this->loadFixtures(['Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData']);
//        $recipes = LoadRecipeData::$members;
//        $recipe = array_pop($recipes);
//
//
//        $this->client->request('PUT', '/api/recipes/'.$recipe->getId(), [], [], [
//                'CONTENT_TYPE' => 'application/json',
//                'Accept' => 'application/json',
//            ],
//            '{"formRecipe":{"name":"changedName"}}'
//        );
//        $this->assertJsonResponse($this->client->getResponse(), Codes::HTTP_NO_CONTENT, false);
//    }
//
//    /**
//     * put for creating a new one (redirect to POST)
//     */
//    public function testPutCreate()
//    {
//        $this->loadFixtures(['Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData']);
//        $this->client->request('PUT', '/api/recipes/0', [], [], [
//                'CONTENT_TYPE' => 'application/json',
//                'Accept' => 'application/json',
//            ],
//            '{"formRecipe":{"name":"changedName"}}'
//        );
//        $this->assertJsonResponse($this->client->getResponse(), Codes::HTTP_CREATED, false);
//    }
//
//
//    /**
//     * put a invalid form
//     */
//    public function testPutInvalid()
//    {
//        $this->loadFixtures(['Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData']);
//        $recipes = LoadRecipeData::$members;
//        $recipe = array_pop($recipes);
//
//        $this->client->request('PUT', '/api/recipes/'.$recipe->getId(), [], [], [
//                'CONTENT_TYPE' => 'application/json',
//                'Accept' => 'application/json',
//            ],
//            '{"name":"fixRecipe1"}'
//        );
//        $this->assertJsonResponse($this->client->getResponse(), Codes::HTTP_BAD_REQUEST);
//    }
//
//    /**
//     * update too a duplicate one via put
//     */
//    public function testPutDuplicate()
//    {
//        $this->loadFixtures(['Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData']);
//        $recipes = LoadRecipeData::$members;
//        $recipe = array_pop($recipes);
//
//        $this->client->request('PUT', '/api/recipes/'.$recipe->getId(), [], [], [
//                'CONTENT_TYPE' => 'application/json',
//                'Accept' => 'application/json',
//            ],
//            '{"formRecipe":{"name":"fixRecipe1"}}'
//        );
//        $this->assertJsonResponse($this->client->getResponse(), Codes::HTTP_UNPROCESSABLE_ENTITY);
//    }
//
//
//    /**
//     * delete one
//     */
//    public function testDelete()
//    {
//        $this->loadFixtures(['Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData']);
//        $recipes = LoadRecipeData::$members;
//        $recipe = array_pop($recipes);
//
//        $this->client->request('DELETE', '/api/recipes/'. $recipe->getId());
//        $this->assertJsonResponse($this->client->getResponse(), Codes::HTTP_NO_CONTENT, false);
//    }
//
//
//    /**
//     * delete a not existing one
//     */
//    public function testDeleteRecipe404()
//    {
//        $this->loadFixtures(['Barra\FrontBundle\DataFixtures\ORM\LoadRecipeData']);
//        $recipes = LoadRecipeData::$members;
//        $recipe = array_pop($recipes);
//
//        $this->client->request('DELETE', '/api/recipes/'. ($recipe->getId()+1) );
//        $this->assertJsonResponse($this->client->getResponse(), Codes::HTTP_NOT_FOUND, false);
//    }
//
//
//    /**
//     * checks status code and returned JSON object if there is one returned
//     * @param $response
//     * @param int $statusCode
//     * @param bool $checkValidJson
//     */
//    protected function assertJsonResponse($response, $statusCode = Codes::HTTP_OK, $checkValidJson = true)
//    {
//        $this->assertEquals($statusCode, $response->getStatusCode(), $response->getContent());
//
//        if ($checkValidJson) {
//            $this->assertTrue($response->headers->contains('content-type', 'application/json'), $response->headers);
//
//            $decode = json_decode($response->getContent());
//            $this->assertTrue(($decode != null && $decode != false), 'is response valid json: [' . $response->getContent() . ']');
//        }
//    }
//}
