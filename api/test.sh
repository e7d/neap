#!/bin/sh

DIR=`dirname $0`
CYAN='\033[4;36m'
DEFAULT='\033[0m'

echo "${CYAN}Enter $DIR directory${DEFAULT}"
cd $DIR

echo "${CYAN}Update composer${DEFAULT}"
composer self-update
composer install --no-interaction --ignore-platform-reqs --prefer-source

echo "${CYAN}Copy latest configuration files${DEFAULT}"
cp config/autoload/local.php.dist config/autoload/local.php
cp config/autoload/oauth2.local.php.dist config/autoload/oauth2.local.php

echo "${CYAN}Run phpunit tests${DEFAULT}"
phpunit -c module/Channel/test/phpunit.xml
