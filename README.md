Kujawa's portfolio
===================

1) Commandline
---------------
  * create bundle       `php app/console generate:bundle --namespace=Acme/DemoBundle --format=yml`
  * create form         `php app/console doctrine:generate:form AcmeDemoBundle:Page --no-interaction`
  * run phpunit tests   `php bin/phpunit -c app/ src/Barra/RestBundle`

2.) Commandline Assets
-----------------------
  * Cache clear prod    `php app/console --env=prod cache:clear`
  * include assets dev  `php app/console assets:install --symlink`
  * include assets prod `php app/console assetic:dump --env=prod --no-debug`

3) Commandline DB
------------------
  * create entity       `php app/console doctrine:generate:entity --entity="BarraDefaultBundle:Product"`
  * create get/set      `php app/console doctrine:generate:entities Barra`
  * load fixtures       `php app/console doctrine:fixtures:load`
  * create DB           `php app/console doctrine:database:create`
  * update DB           `php app/console doctrine:schema:update --force`
  * delete DB           `php app/console doctrine:database:drop --force`

4) Mix
-------
  * filter: `{{ 'reference'|trans({'%name%':'Max'}, 'layout') }}`
  ** reference: `Referenz %name%

  * Transchoice
  ** template `{{ 'front.word.comment'|transchoice(count) }}` yml `comment: '{0} no comment|{1} one comment|]1,Inf] %count% comments'`

  * ordered doctrine findAll()  `public function findAll() {return $this->findBy(array(), array('type'=>'ASC'));}`
  ** pass request to controller `{{ render(controller('...', {'request': app.request})) }}`


5) Bundles
-----------
  * `"symfony/symfony": "2.6"`

  * Tests
  ** `"phpunit/phpunit": "4.5.*"`
  ** `"doctrine/doctrine-fixtures-bundle": "2.2.*"`
  ** `"liip/functional-test-bundle": "~1.0"`

  * Security
  ** `"friendsofsymfony/user-bundle": "~2.0@dev"`

  * RESTful API
  ** `"friendsofsymfony/rest-bundle": "~1.5"`
  ** `"jms/serializer-bundle": "0.13.*"`


POST Recipe
curl -v -H "Accept: application/json" -H "Content-type: application/json" -X POST -d '{"formRecipe":{"name":"fooRecipe"}}' localhost/barra/vpit/web/app_dev.php/api/recipes