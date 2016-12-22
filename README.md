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
* Generate ssh keys:
* `openssl genrsa -out var/jwt/private.pem -aes256 4096`
* `openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem`

### How to: build changes
* `bin/build <dev|prod> [-w]`

### How to: add new js dependency
* `npm i <package> --save[-dev]`
* `node_modules/.bin/jspm install <package>`

### How to: migrate database
* `bin/build doctrine:migrations:diff`
* `bin/build doctrine:migrations:migrate`
