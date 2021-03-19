#!/bin/sh -ex

bin/console --env=test do:sch:up --force
bin/console --env=test do:fix:load -v -n

vendor/bin/phpstan analyse -c phpstan.neon
vendor/bin/ecs check src --fix
bin/phpunit tests/