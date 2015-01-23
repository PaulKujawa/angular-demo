Vpit
==============

1) Commandline
---------------
  * create bundle `php app/console generate:bundle --namespace=Acme/HelloBundle --format=yml`

  * Cache clear prod `./app/console --env=prod cache:clear`

  * Check Route `php app/console router:match /givenPage`

  * include assets dev `php app/console assets:install --symlink`

  * include assets prod `php app/console assetic:dump --env=prod --no-debug`

  * run phpunit tests `php phpunit -c app src/Barra/BackBundle`


2) Commandline DB
------------------
  * create entity `php app/console doctrine:generate:entity --entity="BarraDefaultBundle:Product"`

  * updates get/set/repo `php app/console doctrine:generate:entities Barra`

  * create DB `php app/console doctrine:database:create`

  * update DB `php app/console doctrine:schema:update --force`

  * delete DB `php app/console doctrine:database:drop --force`


3) Redirects
-------------
  * without URL change `return $this->forward('BarraDefaultBundle:Default:recipe', array('id' => 1));`

  * with URL change `return $this->redirect($this->generateUrl('barra_default_recipe', array('id' => 1)));`


4) Check kind of request
-------------------------
  * GET `$request->query->get('page');`
  * POST `$request->request->get('page');`
  * AJAX `$request->isXmlHttpRequest();`
  * Lang `$request->getPreferredLanguage(array('de', 'en'));`
  * Requested format `$format = $this->getRequest()->getRequestFormat();`


5) Trans
----------
  * tag: `{% trans from 'layout' %}reference{% endtrans %}`

  * filter: `{{ 'reference'|trans({'%name%':'Max'}, 'layout') }}`
  ** reference: `Referenz %name%

  * variable key `{{ entry['label']|trans({}, 'layout') }}`


6) Transchoice
----------------
  * template `{{ 'front.word.comment'|transchoice(count) }}`
  * yml `comment: '{0} no comment|{1} one comment|]1,Inf] %count% comments'`


7) mix
--------------------
    * ordered doctrine findAll()  `public function findAll() {return $this->findBy(array(), array('type'=>'ASC'));}`
    * pass request to controller `{{ render(controller('...', {'request': app.request})) }}`


10) Browser support
--------------------
   * IE10+


