# Healthy recipes
---
[![Build Status](https://travis-ci.com/PaulKujawa/vpit.svg?token=uX8iz9gHcJk5sGqwqgvR&branch=master)](https://travis-ci.com/PaulKujawa/vpit)

**Database setup**
* `composer install`
* `bin/console doctrine:database:create`
* `bin/console doctrine:migrations:migrate` or `bin/console doctrine:schema:update --force`

**Build project**
* `npm run build:prod`
