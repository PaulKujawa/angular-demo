Kujawa / vpit
==============

1) Delete Demo Bundle
----------------------
  * delete the `src/Acme` directory;

  * remove the routing entry referencing AcmeDemoBundle in `app/config/routing_dev.yml`;

  * remove the AcmeDemoBundle from the registered bundles in `app/AppKernel.php`;

  * remove the `web/bundles/acmedemo` directory;

  * empty the `security.yml` file or tweak the security configuration to fit your needs.


2) Commandline
---------------
  * create bundle `php app/console generate:bundle --namespace=Acme/HelloBundle --format=yml`

  * Cache clear `./app/console —-env=prod cache:clear`

  * List Routes `./app/console router:debug`

  * Check Route `php app/console router:match /givenPage`

  * include assets `php app/console assets:install web --symlink`

  * check twig syntax `hp app/console twig:lint path_of_bundle|folder|twig-file`


3) Commandline Tests
--------------------
  * run phpunit tests `php phpunit -c app src/Barra/BackBundle`


4) Commandline DB
------------------
  * create entity `php app/console doctrine:generate:entity --entity="BarraDefaultBundle:Product"`

  * updates get/set/repo `php app/console doctrine:generate:entities Barra`

  * create DB `php app/console doctrine:database:create`

  * update DB `php app/console doctrine:schema:update --force`

  * delete DB `php app/console doctrine:database:drop --force`


5) Redirects
-------------
  * without URL change `return $this->forward('BarraDefaultBundle:Default:recipe', array('id' => 1));`

  * with URL change `return $this->redirect($this->generateUrl('barra_default_recipe', array('id' => 1)));`


6) Check kind of request
-------------------------
  * GET `$request->query->get('page');`
  * POST `$request->request->get('page');`
  * AJAX `$request->isXmlHttpRequest();`
  * Lang `$request->getPreferredLanguage(array('de', 'en'));`
  * Requested format `$format = $this->getRequest()->getRequestFormat();`


7) DB Default-Selects
----------------------
  * 1 via PK `find('foo')`

  * 1 with c1 `findOneByColumnName('c1')`

  * 1 with c1&c2 `findOneBy(array('c1'=>'foo', 'c2'=>'bar'))`

  * more with c1 `findByPrice(12.32)`

  * more ordered by c2 `findBy(array('c1'=>'foo'), array('c2'=>'ASC'))`

  * all `findAll()`


8) DB Repository
-----------------

  * Max Id public function findMaxId()
    {
        $query = $this->createQueryBuilder('ri')
            ->select('MAX(ri.id)')
            ->getQuery();

        $recipes = $query->getSingleResult();

        if ($recipes[1] == null)
            return 0;

        return $recipes[1];
    }


9) Template
------------
  * Toggle Table `{% for i in 0..10 %}
    <div class="{{ cycle(['odd', 'even'], i) }}"></div>`

  * Direct template include `{{ include('BarraDefaultBundle:References:article.html.twig', {'id': 3}) }}`


  * Asynchronus include via hinclude.js
    `{{ render_include(url(...)) }}
    {{ render_include(controller(...)) }}
        -> for controller add "fragments: { path: /_fragment } to framework: at app/config/config.yml
        -> default content when js is deactive also there
            framework:
                templating:
                    hinclude_default_template: BarraDefaultBundle::hinclude.html.twig
        -> ovveride this default via:
            {{ render_hinclude(controller('...'), { 'default': '.....twig'}) }}`

10) Trans
----------
  * tag: `{% trans from 'layout' %}reference{% endtrans %}`

  * filter: `{{ 'reference'|trans({'%name%':'Max'}, 'layout') }}`
  ** reference: `Referenz %name%

  * variable key `{{ entry['label']|trans({}, 'layout') }}`


11) Transchoice
----------------
  * filter `{{ 'front.word.comment'|transchoice(count, {}, 'layout') }}

  * tag `{% transchoice count with {'%count%': count} from "layout" %}
  ** front.word.comment
     `{% endtranschoice %}
        comment: '{0} no comment|{1} one comment|]1,Inf] %count% comments'


12) CACHE
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