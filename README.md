# Healthy recipes
---
[![Build Status](https://travis-ci.com/PaulKujawa/vpit.svg?token=uX8iz9gHcJk5sGqwqgvR&branch=master)](https://travis-ci.com/PaulKujawa/vpit)

**Initial setup**
* `composer install`
* `bin/console doctrine:database:create`
* `bin/console doctrine:migrations:migrate`
* `yarn install`

**Build project**
* `npm run build:prod`

**TODO**
* changelogs of zoneJs & typescript
* lazy loading
* HMR
  * package.json ("build:dev": "NODE_ENV=dev webpack-dev-server -w --hot --progress")
  * see TODOs
