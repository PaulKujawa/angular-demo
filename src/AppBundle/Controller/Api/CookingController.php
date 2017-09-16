<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Cooking;
use AppBundle\Form\CookingType;
use AppBundle\Repository\CookingRepository;
use AppBundle\Repository\RecipeRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Security("is_authenticated()")
 */
class CookingController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @var CookingRepository
     */
    private $cookingRepository;

    public function __construct(CookingRepository $cookingRepository)
    {
        $this->cookingRepository = $cookingRepository;
    }

    public function newAction(int $recipeId): View
    {
        return $this->view($this->createForm(CookingType::class));
    }

    public function cgetAction(int $recipeId): View
    {
        $cookings = $this->cookingRepository->getCookings($recipeId);

        return $this->view($cookings);
    }

    public function getAction(int $recipeId, int $id): View
    {
        $cooking = $this->cookingRepository->getCooking($recipeId, $id);

        return null === $cooking
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($cooking);
    }

    public function postAction(Request $request, int $recipeId): View
    {
        $recipe = $this->get(RecipeRepository::class)->getRecipe($recipeId);
        if (null === $recipe) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $position = $this->cookingRepository->getPosition($recipeId);
        $cooking = new Cooking($recipeId, $position);
        $form = $this->createForm(CookingType::class, $cooking);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $cooking = $this->cookingRepository->addCooking($cooking);

        return $this->routeRedirectView('api_get_recipe_cooking', ['recipeId' => $recipeId, 'id' => $cooking->id]);
    }

    public function putAction(Request $request, int $recipeId, $id): View
    {
        $cooking = $this->cookingRepository->getCooking($recipeId, $id);

        if (null === $cooking) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(CookingType::class, $cooking, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->cookingRepository->setCooking($cooking);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    public function deleteAction(int $recipeId, int $id): View
    {
        $cooking = $this->cookingRepository->getCooking($recipeId, $id);

        if (null === $cooking) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        try {
            $this->cookingRepository->deleteCooking($cooking);
        } catch (ForeignKeyConstraintViolationException $ex) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
