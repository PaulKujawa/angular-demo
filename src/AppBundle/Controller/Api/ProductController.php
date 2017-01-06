<?php

namespace AppBundle\Controller\Api;

use AppBundle\Form\ProductType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\GreaterThan;

class ProductController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @return View
     */
    public function newAction(): View
    {
        return $this->view($this->createForm(ProductType::class));
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function getManufacturerAction(int $id): View
    {
        $product = $this->get('app.repository.product')->getProduct($id);

        return null === $product
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($product->getManufacturer());
    }

    /**
     * @QueryParam(name="page", requirements=@GreaterThan(value=0), default="1")
     *
     * @param Request $request
     * @param int $page
     *
     * @return View
     */
    public function cgetAction(Request $request, int $page): View
    {
        $repository = $this->get('app.repository.product');
        $decorator = $this->get('app.request_decorator.product_composite_decorator')->createQueryDecorator($request);

        return $this->view($repository->getProducts($page, $decorator));
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function getAction(int $id): View
    {
        $product = $this->get('app.repository.product')->getProduct($id);

        return null === $product
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($product);
    }

    /**
     * @Security("is_authenticated()")
     *
     * @param Request $request
     *
     * @return View
     */
    public function postAction(Request $request): View
    {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $product = $this->get('app.repository.product')->addProduct($form->getData());

        return $this->view()->createRouteRedirect(
            'api_get_product',
            ['id' => $product->getId()],
            Response::HTTP_CREATED
        );
    }

    /**
     * @param Request $request
     * @param int $id
     *
     * @return View
     */
    public function putAction(Request $request, int $id): View
    {
        $product = $this->get('app.repository.product')->getProduct($id);

        if (null === $product) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(ProductType::class, $product, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->get('app.repository.product')->setProduct($product);

        return $this->view()->createRouteRedirect(
            'api_get_product',
            ['id' => $id],
            Response::HTTP_NO_CONTENT
        );
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function deleteAction(int $id): View
    {
        $product = $this->get('app.repository.product')->getProduct($id);

        if (null === $product) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        try {
            $this->get('app.repository.product')->deleteProduct($product);
        } catch (ForeignKeyConstraintViolationException $ex) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
