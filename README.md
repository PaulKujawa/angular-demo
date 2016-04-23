# Healthy recipes
---
[![Build Status](https://travis-ci.com/barraSargtlin/vpit.svg?token=uX8iz9gHcJk5sGqwqgvR&branch=master)](https://travis-ci.com/barraSargtlin/vpit)

### Here you go
* build                     `bin/build <dev|prod> [-w]`
* optional (JWT)            `openssl genrsa -out app/var/jwt/private.pem -aes256 4096`
                            `openssl rsa -pubout -in app/var/jwt/private.pem -out app/var/jwt/public.pem`


### JS DI structure
* npm
    * package.json = config
    * node_modules = vendors
* jspm
    * package.json = config
    * web/jspm/config.js = lock
    * web/jspm/packages = vendors
* typeScript
    * tsconfig.json = config
    * typings.json = lock
    * typings = vendors
* gulp
    * gulpfile.js --> app/gulp


### Doctrine commands
* DEV
  * delete DB               `bin/console doctrine:database:drop --force`
  * create DB               `bin/console doctrine:database:create`
  * Update DB               `bin/console doctrine:schema:update --force`
* PROD
  * overview                `bin/console doctrine:migrations:status`
  * build 
    * build manually        `bin/console doctrine:migrations:generate`
    * build automatically   `bin/console doctrine:migrations:diff`
  * deploy
    * execute 1 migration   `bin/console doctrine:migrations:execute version`
    * migrate to version    `bin/console doctrine:migrations:migrate [version]`
