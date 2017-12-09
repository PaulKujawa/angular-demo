<?php

namespace AppBundle\Service;

use AppBundle\Model\Pagination;
use AppBundle\Model\PaginationResponse;

class PaginationResponseFactory
{
    public function createPaginationResponse(array $docs, int $pages, int $page, int $pageSize): PaginationResponse {
        $pagination = new Pagination();
        $pagination->page = $page;
        $pagination->pages = $pages;
        $pagination->pageSize = $pageSize;
        $pagination->numFound = count($docs); // TODO represents batched size, not overall size

        $paginationResponse = new PaginationResponse();
        $paginationResponse->pagination = $pagination;
        $paginationResponse->docs = $docs;

        return $paginationResponse;
    }
}
