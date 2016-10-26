<?php

namespace AppBundle\Service;

use AppBundle\Entity\Manufacturer;
use AppBundle\RequestDecorator\Decorator\QueryDecorator;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

class ManufacturerService
{
    const PAGE_LIMIT = 5;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager= $entityManager;
    }

    /**
     * @param int $page
     * @param QueryDecorator $queryDecorator
     *
     * @return Manufacturer[]
     */
    public function getManufacturers($page, QueryDecorator $queryDecorator = null)
    {
        $firstResult = ($page - 1) * self::PAGE_LIMIT;

        $criteria = Criteria::create()
            ->setFirstResult($firstResult)
            ->setMaxResults(self::PAGE_LIMIT);

        if ($queryDecorator) {
            $queryDecorator->decorate($criteria);
        }

        $repository = $this->entityManager->getRepository(Manufacturer::class);

        try {
            return $repository->matching($criteria)->toArray();
        } catch (ORMException $exception) {
            return [];
        }
    }

    /**
     * @param int $id
     *
     * @return Manufacturer|null
     */
    public function getManufacturer($id)
    {
        return $this->entityManager->getRepository(Manufacturer::class)->find($id);
    }

    /**
     * @param Manufacturer $manufacturer
     *
     * @return Manufacturer
     */
    public function addManufacturer(Manufacturer $manufacturer)
    {
        $this->entityManager->persist($manufacturer);
        $this->entityManager->flush($manufacturer);

        return $manufacturer;
    }

    /**
     * @param Manufacturer $manufacturer
     */
    public function setManufacturer(Manufacturer $manufacturer)
    {
        $this->entityManager->flush($manufacturer);
    }

    /**
     * @param Manufacturer $manufacturer
     */
    public function deleteManufacturer(Manufacturer $manufacturer)
    {
        $this->entityManager->remove($manufacturer);
        $this->entityManager->flush($manufacturer);
    }
}
