<?php

namespace AppBundle\Controller\Api;

use AppBundle\Form\ProductType;
use AppBundle\Repository\ProductRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\GreaterThan;

/**
 * @Security("is_authenticated()")
 */
class ProductController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function newAction(): View
    {
        return $this->view($this->createForm(ProductType::class));
    }

    /**
     * @QueryParam(name="page", requirements=@GreaterThan(value=0), default="1")
     */
    public function cgetAction(Request $request, int $page): View
    {
        $decorator = $this->get('app.request_decorator.product_composite_decorator')->createQueryDecorator($request);
        $products = $this->productRepository->getProducts($page, $decorator);

        return $this->view($products);
    }

    public function getAction(int $id): View
    {
        $product = $this->productRepository->getProduct($id);

        return null === $product
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($product);
    }

    public function postAction(Request $request): View
    {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $product = $this->productRepository->addProduct($form->getData());

        return $this->routeRedirectView('api_get_product', ['id' => $product->id], Response::HTTP_CREATED);
    }

    public function putAction(Request $request, int $id): View
    {
        $product = $this->productRepository->getProduct($id);

        if (null === $product) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(ProductType::class, $product, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->productRepository->setProduct($product);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    public function deleteAction(int $id): View
    {
        $product = $this->productRepository->getProduct($id);

        if (null === $product) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        try {
            $this->productRepository->deleteProduct($product);
        } catch (ForeignKeyConstraintViolationException $ex) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
