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


5) DB Default-Selects
----------------------
  * 1 via PK `find('foo')`

  * 1 with c1 `findOneByColumnName('c1')`

  * 1 with c1&c2 `findOneBy(array('c1'=>'foo', 'c2'=>'bar'))`

  * more with c1 `findByPrice(12.32)`

  * more ordered by c2 `findBy(array('c1'=>'foo'), array('c2'=>'ASC'))`

  * all `findAll()`


6) Trans
----------
  * tag: `{% trans from 'layout' %}reference{% endtrans %}`

  * filter: `{{ 'reference'|trans({'%name%':'Max'}, 'layout') }}`
  ** reference: `Referenz %name%

  * variable key `{{ entry['label']|trans({}, 'layout') }}`


7) Transchoice
----------------
  * filter `{{ 'front.word.comment'|transchoice(count, {}, 'layout') }}

  * tag `{% transchoice count with {'%count%': count} from "layout" %}
  ** front.word.comment
     `{% endtranschoice %}
        comment: '{0} no comment|{1} one comment|]1,Inf] %count% comments'


8) CACHE
----------
  * preparation
    use Symfony\Component\HttpFoundation\Response;
    $response = newResponse();
    // mark the response as either public or private
    $response->setPublic();
    $response->setPrivate();

    // set the private or shared max age$response->
    setMaxAge(600);
    $response->setSharedMaxAge(600);

    // set a custom Cache-Control directive
    $response->headers->addCacheControlDirective('must-revalidate', true);

  * example 2
    $response->setCache(array(
    'etag'=>$etag,
    'last_modified'=>$date,
    'max_age'=>10,
    's_maxage'=>10,
    'public'=>true,
    // 'private' => true
    ));

9) doctrine
--------------------
    * order relation `public function findAll() {return $this->findBy(array(), array('type'=>'ASC'));}`

10) Browser support
--------------------
   * IE10+


