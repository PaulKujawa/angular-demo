# Healthy recipes
---
[![Build Status](https://travis-ci.com/PaulKujawa/vpit.svg?token=uX8iz9gHcJk5sGqwqgvR&branch=master)](https://travis-ci.com/PaulKujawa/vpit)

**Initial setup**
* `composer install`
* `bin/console doctrine:database:create`
* `bin/console doctrine:migrations:migrate`

**Build project**
* `npm run build:prod`

**TODO**
* angular doc: `Override default request headers (and other request options)`
* lazy loading
* try to remove npm package "@angular/platform-server"
* symfony to 3.2 (require doctrine/annotations)
* loading icon (http://angularjs.blogspot.de/2017/03/angular-400-now-available.html)
* HMR
  * package.json ("build:dev": "NODE_ENV=dev webpack-dev-server -w --hot --progress")
  * see TODOs
