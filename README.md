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

3) Commandline DB
------------------
  * create entity       `php app/console doctrine:generate:entity --entity="BarraDefaultBundle:Product"`
  * create get/set      `php app/console doctrine:generate:entities Barra`
  * load fixtures       `php app/console doctrine:fixtures:load`
  * create DB           `php app/console doctrine:database:create`
  * update DB           `php app/console doctrine:schema:update --force`
  * delete DB           `php app/console doctrine:database:drop --force`

4) Backend Bundles
-------------------
  * Authentication & Authorization
  ** FOS       user
  ** lexik     jwt-authentication

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

  * Transchoice
  ** template `{{ 'front.word.comment'|transchoice(count) }}` yml `comment: '{0} no comment|{1} one comment|]1,Inf] %count% comments'`

  * ordered doctrine findAll()  `public function findAll() {return $this->findBy(array(), array('type'=>'ASC'));}`
  ** pass request to controller `{{ render(controller('...', {'request': app.request})) }}`