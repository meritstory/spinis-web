#!/usr/bin/env bash

# Make us independent from working directory
pushd `dirname $0` > /dev/null
popd > /dev/null

if [[ -n "$@" ]]; then
  docker compose exec -u www-data -T app bash -c "$@"
else
  docker compose exec -u www-data app bash
fi;

