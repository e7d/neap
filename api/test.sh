#!/bin/bash

DIR=$(dirname `which $0`)

. ${DIR}/../resources/colors.sh

cd ${DIR}

echox "${text_cyan}Update composer"
composer self-update
composer install --no-interaction --ignore-platform-reqs --prefer-source

echox "${text_cyan}Copy latest configuration files"
cp -v config/autoload/local.php.dist config/autoload/local.php
cp -v config/autoload/oauth2.local.php.dist config/autoload/oauth2.local.php

echox "${text_cyan}Run phpunit tests"
./vendor/bin/phpunit -c module/phpunit.xml --coverage-clover ./build/logs/clover.xml

echox "${text_cyan}Check code quality"
./vendor/bin/phpcs --standard=PSR2 module/

echox "${text_cyan}Compute code coverage"
./vendor/bin/coveralls -v
