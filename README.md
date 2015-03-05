Kujawa's portfolio
===================

1) Commandline
---------------
  * create bundle `php app/console generate:bundle --namespace=Acme/HelloBundle --format=yml`

  * Cache clear prod `./app/console --env=prod cache:clear`

  * include assets dev `php app/console assets:install --symlink`

  * include assets prod `php app/console assetic:dump --env=prod --no-debug`

  * run phpunit tests `php bin/phpunit -c app/ [src/Barra/FrontBundle]`


2) Commandline DB
------------------
  * create entity `php app/console doctrine:generate:entity --entity="BarraDefaultBundle:Product"`

  * updates get/set/repo `php app/console doctrine:generate:entities Barra`

  * create DB `php app/console doctrine:database:create`

  * update DB `php app/console doctrine:schema:update --force`

  * delete DB `php app/console doctrine:database:drop --force`


3) Mix
-------
  * filter: `{{ 'reference'|trans({'%name%':'Max'}, 'layout') }}`
  ** reference: `Referenz %name%

  * Transchoice
  ** template `{{ 'front.word.comment'|transchoice(count) }}` yml `comment: '{0} no comment|{1} one comment|]1,Inf] %count% comments'`

  * ordered doctrine findAll()  `public function findAll() {return $this->findBy(array(), array('type'=>'ASC'));}`
  ** pass request to controller `{{ render(controller('...', {'request': app.request})) }}`


4) foo
-------
   * Tested firefox v35, Chrome, IE10+
   * Symfony 2.6


