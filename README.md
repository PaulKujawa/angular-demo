# Healthy recipes
---
[![Build Status](https://travis-ci.com/PaulKujawa/vpit.svg?token=uX8iz9gHcJk5sGqwqgvR&branch=master)](https://travis-ci.com/PaulKujawa/vpit)

### Here you go
* `npm install -g jspm typings gulp; gem install sass`
* `composer install`
* `bin/console doctrine:database:create`
* `bin/console doctrine:migrations:migrate`
* `bin/console assets:install --symlink web`
* `bin/build <dev|prod> [-w]`

#### optional (JWT)
* `openssl genrsa -out app/var/jwt/private.pem -aes256 4096`
* `openssl rsa -pubout -in app/var/jwt/private.pem -out app/var/jwt/public.pem`

### How to: add new js dependency
* `npm i <package> --save`
* `jspm install <package>`
* `typings install <package> --save --global`

### How to: migrate database
* `bin/build doctrine:migrations:diff`
* `bin/build doctrine:migrations:migrate`