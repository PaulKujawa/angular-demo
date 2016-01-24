# Just my crib
---

### Dumps
* dump routes         `php app/console debug:router`
* dump services	      `php app/console debug:container`
* dump default conf   `php app/console config:dump-reference`

### Assets
* Cache clear prod    `php app/console [--env=prod] cache:clear`
* include assets dev  `php app/console assets:install [--symlink]`
* include assets prod `php app/console assetic:dump --env=prod --no-debug`
* compile sass        `grunt sass`

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
