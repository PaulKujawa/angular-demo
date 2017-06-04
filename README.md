# Healthy recipes
---
[![Build Status](https://travis-ci.com/PaulKujawa/vpit.svg?token=uX8iz9gHcJk5sGqwqgvR&branch=master)](https://travis-ci.com/PaulKujawa/vpit)

**Initial setup**
* `composer install`
* `bin/console doctrine:database:create`
* `bin/console doctrine:migrations:migrate` or `bin/console doctrine:schema:update --force`

**Build project**
* `npm run build:prod`

**TODO**
* B: fix webpack watcher
* T: loading icon (http://angularjs.blogspot.de/2017/03/angular-400-now-available.html)
* PO: add vegan label, servings and cook time
* T: add custom ErrorHandler with sentry
* T: HMR
  * package.json ("build:dev": "NODE_ENV=dev webpack-dev-server -w --hot --progress")
  * see TODOs
