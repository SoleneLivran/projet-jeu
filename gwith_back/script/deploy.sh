#!/bin/bash
git pull
composer install
php bin/console doctrine:migrations:migrate
php bin/console cache:clear