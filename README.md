# Just my crib
---

### General
* create bundle       `php app/console generate:bundle --namespace=Barra/DemoBundle --format=yml`
* create form         `php app/console doctrine:generate:form {Bundle:Entity}`
* debug routes        `php app/console debug:router | grep foo`
* dump default conf   `php app/console config:dump-reference`
* dump services	      `php app/console debug:container`

### Assets
* Cache clear prod    `php app/console [--env=prod] cache:clear`
* include assets dev  `php app/console assets:install [--symlink]`
* include assets prod `php app/console assetic:dump --env=prod --no-debug`

### Doctrine
* DEV
  * delete DB           `php app/console doctrine:database:drop --force`
  * create DB           `php app/console doctrine:database:create`
  * Update DB           `php app/console doctrine:schema:update --force`
* PROD
  * overview            `php app/console doctrine:migrations:status`
  * build 
    * build manually      `php app/console doctrine:migrations:generate`
    * build automatically `php app/console doctrine:migrations:diff`
  * deploy
    * execute 1 migration `php app/console doctrine:migrations:execute version`
    * migrate to version  `php app/console doctrine:migrations:migrate [version]`

### Bundles & Libraries
* AuthNAuth           (FOS/User + Lexik/LexikJWTAuthentication)
* Tests               (PHPUnit + LiipFixture/Functional-test)
* API                 (FOS/Rest + JMS/Serializer + FOS/JSRouting)
* Database            (Doctrine/Doctrine-fixtures + Doctrine/doctrine-migrations)
* JS-Libs             (RestAngular, jQuery, ChartJS, Dropzone, bootstrap)


### Temp notices
---
* newest file            `array_multisort(array_map('filemtime', $files), SORT_NUMERIC, SORT_DESC, $files)`
* check form widget e.g. `{% if form.vars.block_prefixes.1 == "checkbox" %}`


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
