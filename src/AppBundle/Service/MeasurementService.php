<?php

namespace AppBundle\Service;

use AppBundle\Entity\Measurement;
use AppBundle\Model\Pagination;
use AppBundle\RequestDecorator\Decorator\QueryDecorator;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

class MeasurementService
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
     *
     * @return Pagination
     */
    public function getPagination($page)
    {
        $count = $this->entityManager->createQueryBuilder()
            ->select('count(m.id)')
            ->from(Measurement::class, 'm')
            ->getQuery()
            ->getSingleScalarResult();

        $pagination = new Pagination();
        $pagination->page = $page;
        $pagination->pages = ceil($count / self::PAGE_LIMIT);

        return $pagination;
    }

    /**
     * @param int $page
     * @param QueryDecorator $queryDecorator
     *
     * @return Measurement[]
     */
    public function getMeasurements($page, QueryDecorator $queryDecorator = null)
    {
        $firstResult = ($page - 1) * self::PAGE_LIMIT;

        $criteria = Criteria::create()
            ->setFirstResult($firstResult)
            ->setMaxResults(self::PAGE_LIMIT);

        if ($queryDecorator) {
            $queryDecorator->decorate($criteria);
        }

        $repository = $this->entityManager->getRepository(Measurement::class);

        try {
            return $repository->matching($criteria)->toArray();
        } catch (ORMException $exception) {
            return [];
        }
    }

    /**
     * @param int $id
     *
     * @return Measurement|null
     */
    public function getMeasurement($id)
    {
        return $this->entityManager->getRepository(Measurement::class)->find($id);
    }

    /**
     * @param Measurement $measurement
     *
     * @return Measurement
     */
    public function addMeasurement(Measurement $measurement)
    {
        $this->entityManager->persist($measurement);
        $this->entityManager->flush($measurement);

        return $measurement;
    }

    /**
     * @param Measurement $measurement
     */
    public function setMeasurement(Measurement $measurement)
    {
        $this->entityManager->flush($measurement);
    }

    /**
     * @param Measurement $measurement
     */
    public function deleteMeasurement(Measurement $measurement)
    {
        $this->entityManager->remove($measurement);
        $this->entityManager->flush($measurement);
    }
}
