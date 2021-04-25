#!/bin/bash
git pull
sudo rm symfony.lock
composer install
php bin/console doctrine:migrations:migrate
php bin/console cache:clear