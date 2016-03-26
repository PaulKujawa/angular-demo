# Just my crib
---

### DEPLOY
* OpenSSL (JWT)             `openssl genrsa -out app/var/jwt/private.pem -aes256 4096`
                            `openssl rsa -pubout -in app/var/jwt/private.pem -out app/var/jwt/public.pem`
* db migration              `app/console doctrine:migrations:diff`
* php                       `composer install`
* clear cache               `app/console cache:clear [--env=prod]`
* jspm                      `jspm install`
* gulp                      `npm install gulp && gulp sass`


### Debug
* dump twig possibilities   `app/console debug:twig`   
* dump routes               `app/console debug:router`
* dump config	            `app/console debug:config`
* dump services	            `app/console debug:container`
* dump default conf         `app/console config:dump-reference`


### Doctrine
* DEV
  * delete DB               `app/console doctrine:database:drop --force`
  * create DB               `app/console doctrine:database:create`
  * Update DB               `app/console doctrine:schema:update --force`
* PROD
  * overview                `app/console doctrine:migrations:status`
  * build 
    * build manually        `app/console doctrine:migrations:generate`
    * build automatically   `app/console doctrine:migrations:diff`
  * deploy
    * execute 1 migration   `app/console doctrine:migrations:execute version`
    * migrate to version    `app/console doctrine:migrations:migrate [version]`
