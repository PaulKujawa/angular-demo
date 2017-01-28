# Healthy recipes
---
[![Build Status](https://travis-ci.com/PaulKujawa/vpit.svg?token=uX8iz9gHcJk5sGqwqgvR&branch=master)](https://travis-ci.com/PaulKujawa/vpit)

## Initial setup

* Dependencies:
* `npm i -g jspm typings gulp; gem install sass`
* `composer install`
* `bin/console assets:install --symlink web`
* Database:
* `bin/console doctrine:database:create`
* `bin/console doctrine:migrations:migrate`

### How to: contribute
* `bin/build <dev|prod> [-w]`

### How to: add new js dependency
* `npm i <package> --save[-dev]`
* `node_modules/.bin/jspm install <package>`

### How to: migrate database
* `bin/console doctrine:migrations:diff`
* `bin/console doctrine:migrations:execute <version>`
