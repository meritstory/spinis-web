#!/bin/bash -x

echo $1

if test $1 -eq "1" ; then
    COMPOSER_ALLOW_SUPERUSER=1 composer install --verbose --prefer-dist --optimize-autoloader --no-progress --no-interaction
    COMPOSER_ALLOW_SUPERUSER=1 composer dump-autoload --no-dev --classmap-authoritative
    yarn install
    php bin/console tailwind:build
fi
