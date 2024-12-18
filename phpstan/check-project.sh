#!/bin/sh

php -d memory_limit=-1 ./vendor/bin/phpstan analyse -c ./phpstan/phpstan.neon
