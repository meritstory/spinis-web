#!/bin/bash

set -euxo pipefail

echo $1

if test $1 -eq "1" ; then
    COMPOSER_ALLOW_SUPERUSER=1 APP_ENV=prod composer install --verbose --prefer-dist --optimize-autoloader --no-progress --no-interaction
    COMPOSER_ALLOW_SUPERUSER=1 APP_ENV=prod composer dump-autoload --no-dev --classmap-authoritative
    yarn install
    APP_ENV=prod php bin/console tailwind:build
    APP_ENV=prod php bin/console asset-map:compile
fi
