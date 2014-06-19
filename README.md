Symfony Standard Edition
========================

2) Checking your System Configuration
-------------------------------------

Before starting coding, make sure that your local system is properly
configured for Symfony.

Execute the `check.php` script from the command line:

    php app/check.php

The script returns a status code of `0` if all mandatory requirements are met,
`1` otherwise.

Access the `config.php` script from a browser:

    http://localhost/path/to/symfony/app/web/config.php

If you get any warnings or recommendations, fix them before moving on.

4) Getting started with Symfony
-------------------------------

This distribution is meant to be the starting point for your Symfony
applications, but it also contains some sample code that you can learn from
and play with.

A great way to start learning Symfony is via the [Quick Tour][4], which will
take you through all the basic features of Symfony2.

Once you're feeling good, you can move onto reading the official
[Symfony2 book][5].

A default bundle, `AcmeDemoBundle`, shows you Symfony2 in action. After
playing with it, you can remove it by following these steps:

  * delete the `src/Acme` directory;

  * remove the routing entry referencing AcmeDemoBundle in `app/config/routing_dev.yml`;

  * remove the AcmeDemoBundle from the registered bundles in `app/AppKernel.php`;

  * remove the `web/bundles/acmedemo` directory;

  * empty the `security.yml` file or tweak the security configuration to fit
    your needs.

######################################################################################################
#####################################################################################################
Commandline
----------------------------------------------------------------------------------------------------
create bundle	            php app/console generate:bundle --namespace=Acme/HelloBundle --format=yml
		                    -> creates src/… & extends app/appkernel.php & app/config/routing.yml

Cache clear	                php app/console cache:clear —env=prod —no-debug
		                    -> necessary when debug is inactive like in prod environment

Base Controller Services    php app/console container:debug

List Routes                 php app/console router:debug

Route <-> URL               php app/console router:match /givenPage


include assets in bundle    php app/console assets:install web --symlink


check twig syntax           php app/console twig:lint path_of_bundle|folder|twig-file


Tests
-----------------------------------------------------------------------------------------------
run phpunit tests           php phpunit -c app src/Barra/BackBundle



DB
---------------------------------------------------------------------------------------------------

create entity               php app/console doctrine:generate:entity --entity="BarraDefaultBundle:Product"
updates get/set/repo        php app/console doctrine:generate:entities Barra


create DB                   php app/console doctrine:database:create
cr/update t                 php app/console doctrine:schema:update --force
delete DB                   php app/console doctrine:database:drop --force







######################################################################################################
######################################################################################################


Routing
------------------------------------------------------------------------------------------------------
User-Agent                  Condition:"request.headers.get('User-Agent') matches'/firefox/i'
                            -> not taken into account when generating url



#####################################################################################################
#####################################################################################################
Controller
----------------------------------------------------------------------------------------------------
Response Obj	            use Symfony\Component\HttpFoundation\Response;

// without URL change:      return $this->forward('BarraDefaultBundle:Default:recipe', array('id' => 1));
// with URL change:         return $this->redirect($this->generateUrl('barra_default_recipe', array('id' => 1))); // = return new RedirectResponse(...);
// for absolute links "true" as 3th param

public function checkRequest(Request $request) {
        $request->isXmlHttpRequest(); // Ajax
        $request->getPreferredLanguage(array('de', 'en'));
        $request->query->get('page'); // $_GET
        $request->request->get('page'); // $_POST
    }


template in different formats       $format = $this->getRequest()->getRequestFormat(); && render...



DB
############################################################################################################
###########################################################################################################

Controller - Einfache selects
    $repository = $this->getDoctrine()->getRepository('BarraDefaultBundle:Recipe')
    $repository
    ->find('foo') 1 with PK
    ->findOneByColumnName('c1') 1 with c1
    ->findOneBy(array('c1'=>'foo', 'c2'=>'bar')) 1 with c1&c2
    ->findByPrice(12.32) more with c1
    ->findBy(array('c1'=>'foo'), array('c2'=>'ASC')) more ordered by c2
    ->findAll();


DB - Repository
 public function findMaxId()
    {
        $query = $this->createQueryBuilder('ri')
            ->select('MAX(ri.id)')
            ->getQuery();

        $recipes = $query->getSingleResult();

        if ($recipes[1] == null)
            return 0;

        return $recipes[1];
    }

######################################################################################################
######################################################################################################
Template
--------------------------------------------------------------------------------------------------------
{% for i in 0..10 %}
    <div class="{{ cycle(['odd', 'even'], i) }}"> ....

{{ include('BarraDefaultBundle:References:article.html.twig', {'id': 3}) }}
include instead of inherit

{{ render(controller('BarraDefaultBundle:References:show', {'id': 3} )) }}
include a complete controller with template for db queries


Asynchronus include via hinclude.js
    {{ render_include(url(...)) }}
    {{ render_include(controller(...)) }}
        -> for controller add "fragments: { path: /_fragment } to framework: at app/config/config.yml
        -> default content when js is deactive also there
            framework:
                templating:
                    hinclude_default_template: BarraDefaultBundle::hinclude.html.twig
        -> ovveride this default via:
            {{ render_hinclude(controller('...'), { 'default': '.....twig'}) }}


bundle template override: app/Resources/myDemoBundle/views/[SomeController/]newPage.html.twig
    -> cache clear may be necessary

######################################################################################################
######################################################################################################
Functional & Unit Tests



---------------------------------------------------------------------------------------------------------------------

newRecipeIngredient->setIngredient($ingredient)
    => aktuallisiert autom.  Recipe->RecipeIngredient
    => Recipe->getRecipeIngredients() funktioniert automatisch


Ingredient->removeRecipeIngredient($recipeIngredient)
    => entfernt nur den Attributswert im Datensatz
    => unpraktisch, da Datensatz (relation) erhalten bliebe
    => wirft sowieso fehlermeldung, da Attribut auf not nullable gesetzt


Ingredient->addRecipeIngredient($recipeIngredient)
    => unnütz. das recipeIngredient müsste bereits bestehen
    => verlinkung zu Ingredient wird autom. gesetzt


























        public function updateRecipe($id, $name, $ingredient, $measurement, $amount, $firstCookingStep)
        {
            $em = $this->getDoctrine()->getManager();
            $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($id);
            $recipe->setName($name)->setRating(50)->setVotes(2);
            $em->flush();
            return new Response('Success! Updated recipe');
        }


        public function deleteRecipeAction($id)
        {
            $em = $this->getDoctrine()->getManager();
            $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($id);

            if (!$recipe)
                throw $this->createNotFoundException('Recipe with id '.$id.' not found');

            $em->remove($recipe);
            $em->flush();
            return new Response('Success! Deleted recipe with id '.$id);
        }










        public function updateRecipeIngredient($id, $recipe, $ingredient, $position, $measurement, $amount)
        {
            $em = $this->getDoctrine()->getManager();
            $recipeIngredient = $em->getepository('BarraFrontBundle:RecipeIngredient')->find($id);
            $recipeIngredient->setRecipe($recipe)->setIngredient($ingredient)->setPosition($position)
                ->setMeasurement($measurement)->setAmount($amount);
            $em->flush();
            return new Response('Success! Updated relation');
        }


        public function deleteRecipeIngredientAction($id)
        {
            $em = $this->getDoctrine()->getManager();
            $recipeIngredient = $em->getRepository('BarraFrontBundle:RecipeIngredient')->find($id);

            if (!$recipeIngredient)
                throw $this->createNotFoundException('Relation with id '.$id.' not found');

            $em->remove($recipeIngredient);
            $em->flush();
            return new Response('Success! Deleted relation with id '.$id);
        }









        public function updateCookingStep($recipe, $step, $description)
        {
            $em = $this->getDoctrine()->getManager();
            $cooking = $em->getRepository('BarraFrontBundle:CookingStep')->findOneBy(array(
                    'recipe'=>$recipe, 'step'=>$step)
            );
            $cooking->setRecipe($recipe)->setStep($step)->setDescription($description);
            $em->flush();
            return new Response('Success! Updated cooking step');
        }


        public function deleteCookingStepAction($recipe, $step)
        {
            $em = $this->getDoctrine()->getManager();
            $cooking = $em->getRepository('BarraFrontBundle:CookingStep')->findOneBy(array(
                    'recipe'=>$recipe, 'step'=>$step)
            );

            if (!$cooking)
                throw $this->createNotFoundException('Cooking step not found');

            $em->remove($cooking);
            $em->flush();
            return new Response('Success! Deleted cooking step');
        }