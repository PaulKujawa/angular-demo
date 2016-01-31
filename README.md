# Just my crib
---

### DEPLOY
* php                       `composer install`
* js                        `bower install`
* clear cache               `app/console cache:clear --env=prod`
* sass compile              `gulp sass`
* compile assets            `app/console assetic:dump --env=prod --no-debug`
* db migration              `app/console doctrine:migrations:diff`


### Dumping
* dump routes               `app/console debug:router`
* dump services	            `app/console debug:container`
* dump default conf         `app/console config:dump-reference`


### Doctrine
* DEV
  * delete DB               `app/console doctrine:database:drop --force`
  * create DB               `app/console doctrine:database:create`
  * Update DB               `app/console doctrine:schema:update --force`
* PROD
  * overview                `app/console doctrine:migrations:status`
  * build 
    * build manually        `app/console doctrine:migrations:generate`
    * build automatically   `app/console doctrine:migrations:diff`
  * deploy
    * execute 1 migration   `app/console doctrine:migrations:execute version`
    * migrate to version    `app/console doctrine:migrations:migrate [version]`
