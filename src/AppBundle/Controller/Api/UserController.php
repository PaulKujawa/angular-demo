<?php

namespace AppBundle\Controller\Api;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Response;

class UserController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @return View
     */
    public function getAction(): View
    {
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->view();
        }

        return $this->view(null, Response::HTTP_UNAUTHORIZED);
    }
}
