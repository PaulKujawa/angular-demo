<?php

namespace Barra\RestBundle\Tests\Controller;

use Barra\RecipeBundle\DataFixtures\ORM\LoadPhotoData;
use Barra\RecipeBundle\DataFixtures\ORM\LoadRecipeData;
use Barra\RecipeBundle\DataFixtures\ORM\LoadUserData;
use FOS\RestBundle\Util\Codes;
use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotoControllerTest extends WebTestCase
{
    private $appType = ['CONTENT_TYPE' => 'application/json'];

    /** @var  Client */
    protected $client;

    /** @var  string */
    protected $uploadPath;

    /**
     * Login with credentials to receive JWT and attach it as future request http_auth header
     */
    public function setUp()
    {
        $this->loadFixtures([LoadUserData::class, LoadRecipeData::class, LoadPhotoData::class]);

        $this->client = static::createClient();
        $this->client->request('POST', '/en/admino/login_check', ['_username' => 'demoSA', '_password' => 'testo']);

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->client->setServerParameter('HTTP_Authorization', 'Bearer ' . $response['token']);
        $this->uploadPath = $this->client->getContainer()->get('kernel')->getRootDir() . '/../web/images/uploads/';
    }

    public function testNew()
    {
        $this->client->request('GET', '/en/api/recipes/1/photos/new');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"children":{"file":[]}}}');
    }

    public function testGet()
    {
        $this->client->request('GET', '/en/api/recipes/1/photos/1');
        preg_match("/.*\"filename\":\"(.*jpeg)/", $this->client->getResponse()->getContent(), $matches);

        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":{"path":"images\/uploads","id":1,"filename":"' . $matches[1] . '","size":145263}}'
        );

        $this->client->request('GET', '/en/api/recipes/2/photos/1');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testCget()
    {
        $this->client->request('GET', '/en/api/recipes/1/photos');
        preg_match(
            "/.*\"filename\":\"(.*jpeg).*\"filename\":\"(.*jpeg)/",
            $this->client->getResponse()->getContent(), $matches
        );

        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":[' .
                '{"path":"images\/uploads","id":1,"filename":"' . $matches[1] . '","size":145263},' .
                '{"path":"images\/uploads","id":2,"filename":"' . $matches[2] . '","size":145263}' .
            ']}'
        );
    }

    public function testPost()
    {
        $this->client->request(
            'POST',
            '/en/api/recipes/1/photos',
            [],
            [
                'photo' => [
                    'file' => $this->createFile(),
                ]
            ]
        );

        $this->validateResponse(Codes::HTTP_CREATED);
        $this->assertStringEndsWith('/en/api/recipes/1/photos/4', $this->client->getResponse()->headers->get('Location'));
        $filename = $this->requestFile(4);
        $this->assertFileExists($this->uploadPath . $filename);
        unlink($this->uploadPath . $filename);
    }

    public function testPostInvalid()
    {
        $this->client->request('POST', '/en/api/recipes/1/photos', [], [], $this->appType, '{}');
        $this->validateResponse(Codes::HTTP_BAD_REQUEST, '{"data":{"children":{"file":[]}}}');
    }

    public function testPut()
    {
        // test automatic overwrite of old file per setting new one
        $oldFilename = $this->requestFile(1);
        $this->createFile($oldFilename);

        $this->client->request(
            'PUT',
            '/en/api/recipes/1/photos/1',
            [],
            [
                'photo' => [
                    'file' => $this->createFile(),
                ]
            ]
        );
        $this->validateResponse(Codes::HTTP_NO_CONTENT);
        $this->assertStringEndsWith('/en/api/recipes/1/photos/1', $this->client->getResponse()->headers->get('Location'));

        $this->assertFileNotExists($this->uploadPath . $oldFilename);
        $newFilename = $this->requestFile(1);
        $this->assertFileExists($this->uploadPath . $newFilename);
        unlink($this->uploadPath . $newFilename);

        $this->client->request('PUT', '/en/api/recipes/2/photos/1', [], [], $this->appType, '{}');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testDelete()
    {
        $this->createFile($this->requestFile(1));
        $this->client->request('DELETE', '/en/api/recipes/1/photos/1');
        $this->validateResponse(Codes::HTTP_NO_CONTENT);

        $this->client->request('DELETE', '/en/api/recipes/2/photos/1');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    /**
     * Create file according to database fixture
     *
     * @param int $id
     *
     * @return string
     */
    protected function requestFile($id)
    {
        $this->client->request('GET', '/en/api/recipes/1/photos/' . $id);

        return json_decode($this->client->getResponse()->getContent(), true)['data']['filename'];
    }

    /**
     * @param string $filename
     *
     * @return UploadedFile
     */
    protected function createFile($filename = 'functionalTest.jpg')
    {
        $newFile = $this->uploadPath . $filename;
        copy($this->uploadPath . 'fixture.jpg', $newFile);

        return (new UploadedFile($newFile, $filename, 'image/jpeg', filesize($newFile), null, true));
    }

    /**
     * @param int $expectedStatusCode
     * @param null|string $expectedJSON
     */
    protected function validateResponse($expectedStatusCode, $expectedJSON = null)
    {
        $this->assertEquals($expectedStatusCode, $this->client->getResponse()->getStatusCode());

        if (null !== $expectedJSON) {
            $this->assertEquals($expectedJSON, $this->client->getResponse()->getContent());
        }
    }
}
