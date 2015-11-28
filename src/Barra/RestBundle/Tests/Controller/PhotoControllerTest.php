<?php

namespace Barra\RestBundle\Tests\Controller;

use FOS\RestBundle\Util\Codes;
use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class PhotoControllerTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Tests\Controller
 */
class PhotoControllerTest extends WebTestCase
{
    /** @var  Client */
    protected $client;
    /** @var  string */
    protected $uploadPath;

    /**
     * Login with credentials to receive JWT and attach it as future request http_auth header
     */
    public function setUp()
    {
        $this->loadFixtures([
            'Barra\AdminBundle\DataFixtures\ORM\LoadUserData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadRecipeData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadPhotoData',
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
        $this->uploadPath = $this->client->getContainer()->get('kernel')->getRootDir().'/../web/uploads/documents/';
    }

    public function testNew()
    {
        $this->client->request('GET', '/en/api/photos/new');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"children":{"recipe":[],"file":[]}}}');
    }

    public function testGet()
    {
        $this->client->request('GET', '/en/api/photos/1');
        preg_match("/.*\"filename\":\"(.*jpeg)/", $this->client->getResponse()->getContent(), $matches);

        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":{"path":"uploads\/documents","id":1,"filename":"'.$matches[1].'","size":145263}}'
        );

        $this->client->request('GET', '/en/api/photos/0');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testCget()
    {
        $this->client->request('GET', '/en/api/photos?limit=2');
        preg_match(
            "/.*\"filename\":\"(.*jpeg).*\"filename\":\"(.*jpeg)/",
            $this->client->getResponse()->getContent(), $matches
        );

        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":['.
                '{"path":"uploads\/documents","id":1,"filename":"'.$matches[1].'","size":145263},'.
                '{"path":"uploads\/documents","id":2,"filename":"'.$matches[2].'","size":145263}'.
            ']}'
        );

        $this->client->request('GET', '/en/api/photos');
        $this->validateResponse(Codes::HTTP_BAD_REQUEST);
    }

    public function testCount()
    {
        $this->client->request('GET', '/en/api/photos/count');
        $this->validateResponse(Codes::HTTP_OK, '{"data":"3"}');
    }

    public function testGetRecipe()
    {
        $this->client->request('GET', '/en/api/photos/1/recipe');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"id":1,"name":"Recipe1"}}');

        $this->client->request('GET', '/en/api/photos/0/recipe');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    /**
     * @depends testGet
     */
    public function testPost()
    {
        $file = $this->createFile();
        $this->client->request(
            'POST',
            '/en/api/photos',
            [
                'formPhoto' => [
                    'recipe' => 1,
                    'file'   => $file,
                ],
            ]
        );

        $this->validateResponse(Codes::HTTP_CREATED);
        $this->assertStringEndsWith('/en/api/photos/4', $this->client->getResponse()->headers->get('Location'));
        $filename = $this->getFilename(4);
        $this->assertFileExists($this->uploadPath.$filename);
        unlink($this->uploadPath.$filename);
    }

    public function testPostInvalid()
    {
        $this->client->request(
            'POST',
            '/en/api/photos',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{}'
        );
        $this->validateResponse(Codes::HTTP_BAD_REQUEST, '{"data":{"children":{"recipe":[],"file":[]}}}');

        $this->client->request(
            'POST',
            '/en/api/photos',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"formPhoto":{"recipe":0}}'
        );
        $this->validateResponse(Codes::HTTP_BAD_REQUEST, '{"data":{"children":{"recipe":[],"file":[]}}}');
    }

    /**
     * @depends testGet
     */
    public function testPut()
    {
        // test automatic overwrite of old file per setting new one
        $oldFilename = $this->getFilename(1);
        $this->createFile($oldFilename);

        $newFile = $this->createFile();
        $this->client->request(
            'PUT',
            '/en/api/photos/1',
            [
                'formPhoto' => [
                    'recipe' => 1,
                    'file'   => $newFile,
                ],
            ]
        );
        $this->validateResponse(Codes::HTTP_NO_CONTENT);
        $this->assertStringEndsWith('/en/api/photos/1', $this->client->getResponse()->headers->get('Location'));

        $this->assertFileNotExists($this->uploadPath.$oldFilename);
        $newFilename = $this->getFilename(1);
        $this->assertFileExists($this->uploadPath.$newFilename);
        unlink($this->uploadPath.$newFilename);

        $this->client->request(
            'PUT',
            '/en/api/photos/0',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{}'
        );
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    /**
     * @depends testGet
     */
    public function testDelete()
    {
        $this->createFile($this->getFilename(1));
        $this->client->request('DELETE', '/en/api/photos/1');
        $this->validateResponse(Codes::HTTP_NO_CONTENT);

        $this->client->request('DELETE', '/en/api/photos/0');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    /**
     * Create file according to database entry (fixture)
     * @param int $id
     * @return string
     */
    protected function getFilename($id)
    {
        $this->client->request('GET', '/en/api/photos/'.$id);
        $dbEntry  = json_decode($this->client->getResponse()->getContent(), true);
        $filename = $dbEntry['data']['filename'];

        return $filename;
    }

    /**
     * @param string $filename
     * @return UploadedFile
     */
    protected function createFile($filename = 'functionalTest.jpg')
    {
        $newFile = $this->uploadPath.$filename;
        copy($this->uploadPath.'fixture.jpg', $newFile);

        $photo = new UploadedFile(
            $newFile,
            $filename,
            'image/jpeg',
            filesize($newFile),
            null,
            true
        );

        return $photo;
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