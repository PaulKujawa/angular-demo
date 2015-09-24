<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Barra\BackBundle\Entity\Reference;
use Barra\BackBundle\Entity\Screenshot;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class LoadScreenshotData
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\DataFixtures\ORM
 */
class LoadScreenshotData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];
    const REL_UPLOAD_PATH  = '/../../../../../web/uploads/documents/';

    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate('Screenshot1', 'refReference1', '1');
        self::$members[] = $this->instantiate('Screenshot2', 'refReference2', '2');
        self::$members[] = $this->instantiate('Screenshot3', 'refReference3', '3');

        foreach (self::$members as $i => $e) {
            $this->addReference('refScreenshot'.($i+1), $e);
            $em->persist($e);
        }
        $em->flush();
    }

    /**
     * @param string        $name
     * @param string        $refReference
     * @param string        $index
     * @return Screenshot
     */
    protected function instantiate($name, $refReference, $index)
    {
        $reference = $this->getReference($refReference);

        if (!$reference instanceof Reference ||
            !is_string($name) ||
            !is_string($index)
        ) {
            throw new InvalidArgumentException();
        }

        $entity = new Screenshot();
        $file = $this->simulateUpload($entity, $index);

        $entity
            ->setName($name)
            ->setReference($reference)
            ->setFile($file)
            ->setSize($file->getClientSize())
        ;

        return $entity;
    }

    /**
     * @param Screenshot  $entity
     * @param string            $index
     * @return UploadedFile
     */
    protected function simulateUpload(Screenshot $entity, $index)
    {
        // set up demo picture to simulate an upload
        $demoFileName   = 'refFixture'.$index.'jpg';
        $demoFile       = $entity->getAbsolutePath().DIRECTORY_SEPARATOR.$demoFileName;

        copy(
            $entity->getAbsolutePath().'/fixture.jpg',
            $demoFile
        );

        // 'receive' uploaded file and instantiate an representing object
        return new UploadedFile(
            $demoFile,
            $demoFileName,
            null,
            filesize($demoFile),
            null,
            true
        );
    }

    public function getOrder()
    {
        return 11;
    }
}
