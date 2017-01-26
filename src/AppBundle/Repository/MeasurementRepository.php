<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Measurement;
use AppBundle\Model\PaginationResponse;
use AppBundle\RequestDecorator\Decorator\QueryDecorator;
use AppBundle\Service\PaginationResponseFactory;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

class MeasurementRepository
{
    const PAGE_LIMIT = 5;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var PaginationResponseFactory
     */
    private $paginationResponseFactory;

    /**
     * @param EntityManager $entityManager
     * @param PaginationResponseFactory $paginationResponseFactory
     */
    public function __construct(
        EntityManager $entityManager,
        PaginationResponseFactory $paginationResponseFactory
    ) {
        $this->entityManager= $entityManager;
        $this->paginationResponseFactory = $paginationResponseFactory;
    }

    /**
     * @param int $page
     * @param QueryDecorator $queryDecorator
     *
     * @return PaginationResponse
     */
    public function getMeasurements(int $page, QueryDecorator $queryDecorator = null): PaginationResponse
    {
        $repository = $this->entityManager->getRepository(Measurement::class);
        $firstResult = ($page - 1) * self::PAGE_LIMIT;
        $criteria = Criteria::create();

        if ($queryDecorator) {
            $queryDecorator->decorate($criteria);
        }

        try {
            $measurements = $repository->matching($criteria);
        } catch (ORMException $exception) {
            $measurements = [];
        }

        // TODO workaround with shitty performance! Criteria misses support for count yet!
        $docs = array_values($measurements->slice($firstResult, self::PAGE_LIMIT));

        $paginationResponse = $this->paginationResponseFactory->createPaginationResponse(
            $docs,
            $measurements->count(),
            self::PAGE_LIMIT,
            $page
        );

        return $paginationResponse;
    }

    /**
     * @param int $id
     *
     * @return Measurement|null
     */
    public function getMeasurement(int $id)
    {
        return $this->entityManager->getRepository(Measurement::class)->find($id);
    }

    /**
     * @param Measurement $measurement
     *
     * @return Measurement
     */
    public function addMeasurement(Measurement $measurement): Measurement
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
