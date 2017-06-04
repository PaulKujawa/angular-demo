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
        $criteria = Criteria::create();
        $criteria->setFirstResult(self::PAGE_LIMIT * ($page - 1));
        $criteria->setMaxResults(self::PAGE_LIMIT);

        if ($queryDecorator) {
            $queryDecorator->decorate($criteria);
        }

        $repository = $this->entityManager->getRepository(Measurement::class);

        try {
            $measurements = $repository->matching($criteria);
        } catch (ORMException $exception) {
            $measurements = [];
        }

        $paginationResponse = $this->paginationResponseFactory->createPaginationResponse(
            $measurements->toArray(),
            1, // todo mocked
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
