#!/bin/sh

##
# Add all phpstan warning to ignore list in phpstan-baseline.neon from code.
# Use this only when you fixed all warnings that are fixable and want to ignore the rest.
##

# exit script on first failed command or unset variable
set -eu
# echo on
#set -x

# get current script dir
# https://stackoverflow.com/q/59895/846432
DIR=$(dirname "$(realpath $0)")
APP_DIR=$(realpath ${DIR}/..)

printf "1. Disabling phpstan-baseline.neon inclusion from phpstan/phpstan.neon..."
sed --in-place 's/- phpstan-baseline.neon/#- phpstan-baseline.neon/' $DIR/phpstan.neon
echo "done."

echo "2. Updating phpstan-baseline.neon..."
$APP_DIR/vendor/bin/phpstan --allow-empty-baseline  analyse  -c ./phpstan/phpstan.neon --generate-baseline ./phpstan/phpstan-baseline.neon
echo "done."

printf "3. Enabling disabled phpstan-baseline.neon inclusion..."
sed --in-place 's/#- phpstan-baseline.neon/- phpstan-baseline.neon/' $DIR/phpstan.neon
echo "done."
