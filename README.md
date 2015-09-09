Kujawa's portfolio
===================

1) Commandline
---------------
  * create bundle       `php app/console generate:bundle --namespace=Barra/DemoBundle --format=yml`
  * create form         `php app/console doctrine:generate:form BarraDemoBundle:Entity --no-interaction`
  * run phpunit tests   `php bin/phpunit -c app/ [src/Barra/DemoBundle]`
  * list exposed routes `php app/console fos:js-routing:debug [routeName]`

2.) Commandline Assets
-----------------------
  * Cache clear prod    `php app/console --env=prod cache:clear`
  * include assets dev  `php app/console assets:install --symlink`
  * include assets prod `php app/console assetic:dump --env=prod --no-debug`

3) Commandline Database
------------------------
  * create entity       `php app/console doctrine:generate:entity --entity="BarraDefaultBundle:Product"`
  * create get/set      `php app/console doctrine:generate:entities Barra`
  * load fixtures       `php app/console doctrine:fixtures:load`
  * create DB           `php app/console doctrine:database:create`
  * CR/U Tables         `php app/console doctrine:schema:update --force`
  * delete DB           `php app/console doctrine:database:drop --force`

4) Backend Bundles
-------------------
  * Authentication & Authorization
  ** FOS       user
  ** lexik     LexikJWTAuthentication

  * Tests
  ** phpunit   phpunit
  ** doctrine  doctrine-fixtures

  * RESTful API
  ** FOS       rest
  ** jms       serializer
  ** liip      functional-test

  * Mix
  ** FOS        jsrouting

5.) Frontend Libraries
-----------------------
  ** RestAngular
  ** Lodash
  ** jquery
  ** bootstrap
  ** chartjs
  ** dropzone


6) Notices for myself
----------------------
  * filter: `{{ 'reference'|trans({'%name%':'Max'}, 'layout') }}`
  ** reference: `Referenz %name%

  * Form Theming
  ** check widget e.g. `{% if form.vars.block_prefixes.1 == "checkbox" %}`

  * handle forms manually
  ** `...handleRequest($request)` && `$id = $form->all()->getId()`


```php
    if ($posBefore < $posAfter) {
        $repo->changeBetweenPos($recipeId, $posBefore+1, $posAfter, -1);
    } else {
        $repo->changeBetweenPos($recipeId, $posAfter, $posBefore-1, 1);
    }
    /**
     * @param int   $recipeId
     * @param int   $posBefore
     * @param int   $posAfter
     * @param int   $difference
     * @return array
     */
    public function changeBetweenPos($recipeId, $posBefore, $posAfter, $difference)
    {
        $query = $this->createQueryBuilder('i')
            ->update()
            ->set('i.position', 'i.position + :difference')
            ->where('i.recipe = :recipeId')
            ->andWhere('i.position BETWEEN :posBefore AND :posAfter')
            ->setParameter('posBefore', $posBefore)
            ->setParameter('posAfter', $posAfter)
            ->setParameter('recipeId', $recipeId)
            ->setParameter('difference', $difference)
            ->getQuery()
        ;
        return $query->getResult();
    }
```