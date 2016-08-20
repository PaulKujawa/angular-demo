# Healthy recipes
---
[![Build Status](https://travis-ci.com/barraSargtlin/vpit.svg?token=uX8iz9gHcJk5sGqwqgvR&branch=master)](https://travis-ci.com/barraSargtlin/vpit)

### Here you go
* configure paramters   `composer install`
* create database       `doctrine:database:create`
* migrate database      `doctrine:migrations:migrate`
* build assets          `bin/build <dev|prod> [-w]`
* optional (JWT)        `openssl genrsa -out app/var/jwt/private.pem -aes256 4096`
                        `openssl rsa -pubout -in app/var/jwt/private.pem -out app/var/jwt/public.pem`


### JS DI structure
* npm
    * add               `npm i @angular/forms --save`
    * config            package.json (dependencies)
    * vendors           node_modules
* jspm
    * dependencies      package.json (jspm)
    * config/lock       web/jspm/config.js
    * vendors           web/jspm/packages
* ts compiler
    * default loader    typings/index.d.ts
                        when missing every vendor is laoded
                        can be overridden
* ts typings
    * add               `typings install <package> --save --global`
    * lock              typings.json
    * vendors           typings
* gulp
    * gulpfile.js --> app/gulp
