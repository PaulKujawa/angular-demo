# Healthy recipes
---
[![Build Status](https://travis-ci.com/PaulKujawa/vpit.svg?token=uX8iz9gHcJk5sGqwqgvR&branch=master)](https://travis-ci.com/PaulKujawa/vpit)

### Here you go
* install `npm install -g jspm typings gulp && gem install sass`
* configure parameters `composer install`
* setup database `bin/console doctrine:database:create` & `bin/console doctrine:migrations:migrate`
* build assets `bin/build <dev|prod> [-w]`
* optional (JWT)        `openssl genrsa -out app/var/jwt/private.pem -aes256 4096`
                        `openssl rsa -pubout -in app/var/jwt/private.pem -out app/var/jwt/public.pem`
