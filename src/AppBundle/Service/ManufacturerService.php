<?php

namespace AppBundle\Service;

use AppBundle\Entity\Manufacturer;
use Doctrine\ORM\EntityManager;

class ManufacturerService
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
     * @return Manufacturer[]|array
     */
    public function getManufacturers($orderBy, $order, $limit, $offset)
    {
        return $this->entityManager->getRepository(Manufacturer::class)->findBy(
            [],
            [$orderBy => $order],
            $limit,
            $offset
        );
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
