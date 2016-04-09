# Notes for my home project
---
[![Build Status](https://travis-ci.com/barraSargtlin/vpit.svg?token=uX8iz9gHcJk5sGqwqgvR&branch=master)](https://travis-ci.com/barraSargtlin/vpit)

### ToDo
* pagination (KnpPaginationBundle?)
* angular2 basic implementation
* gulp tasks in typescript

### DEPLOY
* OpenSSL (JWT)             `openssl genrsa -out app/var/jwt/private.pem -aes256 4096`
                            `openssl rsa -pubout -in app/var/jwt/private.pem -out app/var/jwt/public.pem`
* php vendors               `composer install`
* db migration              `bin/console doctrine:migrations:diff`
* clear cache               `bin/console cache:clear [--env=prod]`
* js vendors                `jspm install`
* gulp                      `npm install gulp && gulp sass`


### Debug
* dump twig possibilities   `bin/console debug:twig`   
* dump routes               `bin/console debug:router`
* dump config	            `bin/console debug:config`
* dump services	            `bin/console debug:container`
* dump default conf         `bin/console config:dump-reference`


### Doctrine
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

### Mix
* access hidden form type   `$request->request->all()[0]['field']`
