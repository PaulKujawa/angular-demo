# Healthy recipes
---
[![Build Status](https://travis-ci.com/barraSargtlin/vpit.svg?token=uX8iz9gHcJk5sGqwqgvR&branch=master)](https://travis-ci.com/barraSargtlin/vpit)

### Here you go
* configure parameters `composer install`
* setup database `bin/console doctrine:database:create` & `bin/console doctrine:migrations:migrate`
* build assets `bin/build <dev|prod> [-w]`
* optional (JWT)        `openssl genrsa -out app/var/jwt/private.pem -aes256 4096`
                        `openssl rsa -pubout -in app/var/jwt/private.pem -out app/var/jwt/public.pem`

### JavaScript
* npm `npm i <package> --save`
* typings `typings install <package> --save --global`
* jspm `jspm install <package>`
* run gulp `gulp watch`


### Required
* npm `via node.js`
* jspm `npm install -g jspm`
* typings `npm install -g typings`
* gulp `npm install -g gulp`
* sass `gem install sass`
