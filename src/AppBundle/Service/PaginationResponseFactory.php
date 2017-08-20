<?php

namespace AppBundle\Service;

use AppBundle\Model\Pagination;
use AppBundle\Model\PaginationResponse;

class PaginationResponseFactory
{
    public function createPaginationResponse(array $docs, int $pages, int $page): PaginationResponse {
        $pagination = new Pagination();
        $pagination->page = $page;
        $pagination->pages = $pages;

        $paginationResponse = new PaginationResponse();
        $paginationResponse->pagination = $pagination;
        $paginationResponse->docs = $docs;

        return $paginationResponse;
    }
}
