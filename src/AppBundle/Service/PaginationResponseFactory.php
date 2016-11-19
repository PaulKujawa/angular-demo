<?php

namespace AppBundle\Service;

use AppBundle\Entity\Recipe;
use AppBundle\Model\Pagination;
use AppBundle\Model\PaginationResponse;
use AppBundle\RequestDecorator\Decorator\QueryDecorator;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

class PaginationResponseFactory
{
    /**
     * @param array $docs
     * @param int $totalCount
     * @param int $pageSize
     * @param int $currentPage
     *
     * @return PaginationResponse
     */
    public function createPaginationResponse(array $docs, $totalCount, $pageSize, $currentPage)
    {
        $pagination = new Pagination();
        $pagination->page = $currentPage;
        $pagination->pages = ceil($totalCount / $pageSize);

        $paginationResponse = new PaginationResponse();
        $paginationResponse->pagination = $pagination;
        $paginationResponse->docs = $docs;

        return $paginationResponse;
    }
}
