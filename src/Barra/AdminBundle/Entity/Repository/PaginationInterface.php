<?php

namespace Barra\AdminBundle\Entity\Repository;

/**
 * Interface PaginationInterface
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Entity\Repository
 */
interface PaginationInterface
{
    /**
     * @return int
     */
    public function count();
}
