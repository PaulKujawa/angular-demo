Just my crib
=============

1) Create Bundle, Form, Route
------------------------------
  * create bundle       `php app/console generate:bundle --namespace=Barra/DemoBundle --format=yml`
  * create form         `php app/console doctrine:generate:form BarraAdminBundle:EntityName --no-interaction`
  * debug routes        `php app/console debug:router | grep foo`
  
2.) Assets/Assetic
-------------------
  * Cache clear prod    `php app/console --env=prod cache:clear`
  * include assets dev  `php app/console assets:install --symlink`
  * include assets prod `php app/console assetic:dump --env=prod --no-debug`

3) Doctrine
------------
  * delete DB           `php app/console doctrine:database:drop --force`
  * create DB           `php app/console doctrine:database:create`
  * Tables in Dev       `php app/console doctrine:schema:update --force`
  
  * load fixtures       `php app/console doctrine:fixtures:load --append`
  * create entity       `php app/console doctrine:generate:entity --entity="BarraAdminBundle:Demo"`
  * create get/set      `php app/console doctrine:generate:entities Barra`
  
4. Doctrine migrations
-----------------------
doctrine:migrations
  * overview            `php app/console doctrine:migrations:status`
  * build automatically `php app/console doctrine:migrations:diff`
  * build manually      `php app/console doctrine:migrations:generate`
  
  * execute 1 migration `php app/console doctrine:migrations:execute [up|down] version`
  * migrate to version  `php app/console doctrine:migrations:migrate [version]`
  
5) 3rd Party quick overview
----------------------------
  * AuthNAuth           (FOS/User + Lexik/LexikJWTAuthentication)
  * Tests               (PHPUnit + LiipFixture/Functional-test)
  * API                 (FOS/Rest + JMS/Serializer + FOS/JSRouting)
  * Database            (Doctrine/Doctrine-fixtures + Doctrine/doctrine-migrations)
  * JS-Libs             (RestAngular, jQuery, ChartJS, Dropzone, bootstrap)

6) Notices for myself
----------------------
  * Forms
  ** check widget e.g. `{% if form.vars.block_prefixes.1 == "checkbox" %}`
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