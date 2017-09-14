<?php

namespace AppBundle\Controller\Api;

use AppBundle\Form\RecipeType;
use AppBundle\Repository\RecipeRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\GreaterThan;

class RecipeController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @var RecipeRepository
     */
    private $recipeRepository;

    public function __construct(RecipeRepository $recipeRepository)
    {
        $this->recipeRepository = $recipeRepository;
    }

    public function newAction(): View
    {
        return $this->view($this->createForm(RecipeType::class));
    }

    /**
     * @QueryParam(name="page", requirements=@GreaterThan(value=0), default="1")
     */
    public function cgetAction(Request $request, int $page): View
    {
        $decorator = $this->get('app.request_decorator.recipe_composite_decorator')->createQueryDecorator($request);

        $context = new Context();
        $context->setGroups(['Default', 'recipeList']);

        $view = $this->view($this->recipeRepository->getRecipes($page, $decorator));
        $view->setContext($context);

        return $view;
    }

    public function getAction(int $id): View
    {
        $recipe = $this->recipeRepository->getRecipe($id);

        if (null === $recipe) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $context = new Context();
        $context->setGroups(['Default', 'recipeDetail']);

        $view = $this->view($recipe);
        $view->setContext($context);

        return $view;
    }

    /**
     * @Security("is_authenticated()")
     */
    public function postAction(Request $request): View
    {
        $form = $this->createForm(RecipeType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $recipe = $this->recipeRepository->addRecipe($form->getData());

        return $this->routeRedirectView('api_get_recipe', ['id' => $recipe->id], Response::HTTP_CREATED);
    }

    /**
     * @Security("is_authenticated()")
     */
    public function putAction(Request $request, int $id): View
    {
        $recipe = $this->recipeRepository->getRecipe($id);

        if (null === $recipe) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(RecipeType::class, $recipe, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->recipeRepository->setRecipe($recipe);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Security("is_authenticated()")
     */
    public function deleteAction(int $id): View
    {
        $recipe = $this->recipeRepository->getRecipe($id);

        if (null === $recipe) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        try {
            $this->recipeRepository->deleteRecipe($recipe);
        } catch (ForeignKeyConstraintViolationException $ex) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
