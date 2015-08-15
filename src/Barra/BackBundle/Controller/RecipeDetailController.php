<?php

namespace Barra\BackBundle\Controller;

use Barra\BackBundle\Form\Type\CookingType;
use Barra\BackBundle\Form\Type\IngredientType;
use Barra\BackBundle\Form\Type\RecipePictureType;
use Barra\FrontBundle\Entity\Cooking;
use Barra\FrontBundle\Entity\Ingredient;
use Barra\FrontBundle\Entity\RecipePicture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RecipeDetailController extends Controller
{
    /**
     * @param $name
     * @return Response
     */
    public function indexAction($name)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->findOneByName(str_replace('_', ' ', $name));
        if (!$recipe) {
             throw new NotFoundHttpException();
        }

        $cookings = $em->getRepository('BarraFrontBundle:Cooking')->findByRecipe($recipe, array('position'=>'ASC'));

        $formPicture = $this->createForm(new RecipePictureType(),   new RecipePicture());
        $formCooking = $this->createForm(new CookingType(),         new Cooking());
        $formProduct = $this->createForm(new IngredientType(),      new Ingredient());

        $formPicture->get('recipe')->setData($recipe->getId());

        return $this->render('BarraBackBundle:Recipe:recipeDetail.html.twig', array(
                'recipe'        => $recipe,
                'cookings'      => $cookings,
                'formPicture'   => $formPicture->createView(),
                'formProduct'   => $formProduct->createView(),
                'formCooking'   => $formCooking->createView(),
            ));
    }



    public function uploadPictureAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $recipeId = $request->request->get('formRecipePicture')['recipe'];
        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($recipeId);

        if (!$recipe)
            $this->createNotFoundException('Recipe not found');

        foreach($request->files as $file) { // not necessary, since dropzone sends for every file an own request which depends on current config
            $recipeFile = new RecipePicture();

            $form = $this->createForm(new RecipePictureType(), $recipeFile);
            $form->handleRequest($request);
            $recipeFile->setRecipe($recipe);
            $recipeFile->setSize($file->getClientSize());
            $recipeFile->setFile($file);

            if ($form->isValid()) {
                $em->persist($recipeFile);
                $em->flush();
                $id = $recipeFile->getId();
                $ajaxResponse = array("code"=>404, "id"=>$id);
            } else {
                $validationError = $this->get('barra_back.formValidation')->getErrorMessages($form);
                $ajaxResponse = array("code"=>400, "message"=>$validationError);
            }
        }
        return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
    }



    public function getPicturesAction($recipeId)
    {
        $em = $this->getDoctrine()->getManager();
        $files = $em->getRepository('BarraFrontBundle:RecipePicture')->findByRecipe($recipeId);

        $container = array();
        for ($i=0; $i < count($files); $i++) {
            $container[$i]['id']        = $files[$i]->getId();
            $container[$i]['title']     = $files[$i]->getTitle();
            $container[$i]['filename']  = $files[$i]->getFilename();
            $container[$i]['size']      = $files[$i]->getSize();
        }

        $ajaxResponse = array("code"=>200, "files"=>$container);
        return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
    }



    public function deletePictureAction($recipeId, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $file = $em->getRepository('BarraFrontBundle:RecipePicture')->find($id);

        if (!$file)
            throw $this->createNotFoundException('File not found');

        $em->remove($file);
        $em->flush();

        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($recipeId);
        return $this->redirect($this->generateUrl('barra_back_recipeDetail', array('name'=>$recipe->getName())));
    }
}
