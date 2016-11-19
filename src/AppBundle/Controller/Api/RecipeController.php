<?php

namespace AppBundle\Controller\Api;

use AppBundle\Form\RecipeType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View as AnnotationsView;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\GreaterThan;

class RecipeController extends FOSRestController implements ClassResourceInterface
{
    const PAGE_LIMIT = 5;

    /**
     * @return View
     */
    public function newAction()
    {
        return $this->view($this->createForm(RecipeType::class));
    }

    /**
     * @QueryParam(name="page", requirements=@GreaterThan(value=0), default="1")
     *
     * @param Request $request
     * @param int $page
     *
     * @return View
     */
    public function cgetAction(Request $request, $page)
    {
        $repository = $this->get('app.repository.recipe');
        $decorator = $this->get('app.request_decorator.recipe_composite_decorator')->createQueryDecorator($request);

        $view = $this->view($repository->getRecipes((int) $page, $decorator));
        $view->setSerializationContext(SerializationContext::create()->setGroups(['Default', 'recipeList']));

        return $view;
    }

    /**
     * @AnnotationsView(serializerGroups={"Default", "recipeDetail"})
     *
     * @param int $id
     *
     * @return View
     */
    public function getAction($id)
    {
        $recipe = $this->get('app.repository.recipe')->getRecipe($id);

        return $recipe ?: $this->view(null, Response::HTTP_NOT_FOUND);
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function postAction(Request $request)
    {
        $form = $this->createForm(RecipeType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $recipe = $this->get('app.repository.recipe')->addRecipe($form->getData());

        return $this->view()->createRouteRedirect(
            'api_get_recipe',
            ['id' => $recipe->getId()],
            Response::HTTP_CREATED
        );
    }

    /**
     * @param Request $request
     * @param int $id
     *
     * @return View
     */
    public function putAction(Request $request, $id)
    {
        $recipe = $this->get('app.repository.product')->getProduct($id);

        if (null === $recipe) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(RecipeType::class, $recipe, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->get('app.repository.recipe')->setRecipe($recipe);

        return $this->view()->createRouteRedirect(
            'api_get_recipe',
            ['id' => $id],
            Response::HTTP_NO_CONTENT
        );
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function deleteAction($id)
    {
        $recipe = $this->get('app.repository.recipe')->getRecipe($id);

        if (null === $recipe) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        try {
            $this->get('app.repository.recipe')->deleteRecipe($recipe);
        } catch (ForeignKeyConstraintViolationException $ex) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
