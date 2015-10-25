<?php

namespace Barra\AdminBundle\DataFixtures\ORM;

use Barra\AdminBundle\Entity\Agency;
use Barra\AdminBundle\Entity\Reference;
use Barra\AdminBundle\Entity\Technique;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class LoadReferenceData
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\DataFixtures\ORM
 */
class LoadReferenceData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];


    const REL_UPLOAD_PATH  = '/../../../../../web/uploads/documents/';


    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate(
            'http://a.de',
            'description1',
            new \DateTime(),
            new \DateTime(),
            'refAgency1',
            1,
            [
                'refTechnique1',
            ]
        );
        self::$members[] = $this->instantiate(
            'http://b.de',
            'description2',
            new \DateTime(),
            new \DateTime(),
            'refAgency2',
            2,
            [
                'refTechnique1',
                'refTechnique2',
                'refTechnique3',
            ]
        );
        self::$members[] = $this->instantiate(
            'http://c.de',
            'description3',
            new \DateTime(),
            new \DateTime(),
            'refAgency3',
            3,
            [
                'refTechnique1',
                'refTechnique2',
            ]
        );

        foreach (self::$members as $i => $e) {
            $this->addReference('refReference'.($i+1), $e);
            $em->persist($e);
        }
        $em->flush();
    }


    /**
     * @param string    $url
     * @param string    $description
     * @param \DateTime $started
     * @param \DateTime $finished
     * @param string    $refAgency
     * @param int       $index
     * @param array     $refTechniques
     * @return Reference
     * @throws InvalidArgumentException
     */
    protected function instantiate($url, $description, \DateTime $started, \DateTime $finished, $refAgency, $index, array $refTechniques)
    {
        $agency = $this->getReference($refAgency);

        if (!$agency instanceof Agency) {
            throw new InvalidArgumentException();
        }

        $copyName = 'fixtureCopy'.$index;
        $origPath = __DIR__.self::REL_UPLOAD_PATH.'fixture.jpg';
        $copyPath = __DIR__.self::REL_UPLOAD_PATH.$copyName.'.jpg';
        $size     = filesize($origPath);

        copy($origPath, $copyPath);
        $file   = new UploadedFile($copyPath, $copyName, null, $size, null, true);
        $entity = new Reference();
        $entity
            ->setUrl($url)
            ->setDescription($description)
            ->setAgency($agency)
            ->setStarted($started)
            ->setFinished($finished)
            ->setFile($file)
            ->setSize($size)
        ;

        foreach ($refTechniques as $refTechnique) {
            $technique = $this->getReference($refTechnique);
            if (!$technique instanceof Technique) {
                throw new \InvalidArgumentException();
            }
            $entity->addTechnique($technique);
        }

        return $entity;
    }


    public function getOrder()
    {
        return 10;
    }
}
