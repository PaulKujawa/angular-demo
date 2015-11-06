# Just my crib
---

### Create Bundle, Form, Route
* create bundle       `php app/console generate:bundle --namespace=Barra/DemoBundle --format=yml`
* create form         `php app/console doctrine:generate:form {Bundle:Entity} --no-interaction`
* debug routes        `php app/console debug:router | grep foo`

### Assets
* Cache clear prod    `php app/console --env=prod cache:clear`
* include assets dev  `php app/console assets:install --symlink`
* include assets prod `php app/console assetic:dump --env=prod --no-debug`

### Doctrine
* DEV
  * delete DB           `php app/console doctrine:database:drop --force`
  * create DB           `php app/console doctrine:database:create`
  * Update DB           `php app/console doctrine:schema:update --force`
  * load fixtures       `php app/console doctrine:fixtures:load --append`
* TEST
  * just functional tests, which use a separate, cached SQLite db
* PROD
  * overview            `php app/console doctrine:migrations:status`
  * build 
    * build manually      `php app/console doctrine:migrations:generate`
    * build automatically `php app/console doctrine:migrations:diff`
  * deploy
    * execute 1 migration `php app/console doctrine:migrations:execute [up|down] version`
    * migrate to version  `php app/console doctrine:migrations:migrate [version]`

### Bundles & Libraries
* AuthNAuth           (FOS/User + Lexik/LexikJWTAuthentication)
* Tests               (PHPUnit + LiipFixture/Functional-test)
* API                 (FOS/Rest + JMS/Serializer + FOS/JSRouting)
* Database            (Doctrine/Doctrine-fixtures + Doctrine/doctrine-migrations)
* JS-Libs             (RestAngular, jQuery, ChartJS, Dropzone, bootstrap)


### Temp notices
---
* check form widget e.g. `{% if form.vars.block_prefixes.1 == "checkbox" %}`
* get all request values `...handleRequest($request)` && `$id = $form->all()->getId()`


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