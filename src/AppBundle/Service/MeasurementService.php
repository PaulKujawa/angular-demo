<?php

namespace AppBundle\Service;

use AppBundle\Entity\Measurement;
use Doctrine\ORM\EntityManager;

class MeasurementService
{
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
     * @param string $orderBy
     * @param string $order
     * @param int $limit
     * @param int $offset
     *
     * @return Measurement[]|array
     */
    public function getMeasurements($orderBy, $order, $limit, $offset)
    {
        return $this->entityManager->getRepository(Measurement::class)->findBy(
            [],
            [$orderBy => $order],
            $limit,
            $offset
        );
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
