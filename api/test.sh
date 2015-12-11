#!/bin/sh

DIR=`dirname $0`
cd $DIR
ls

echo "Update composer"
composer self-update
composer install --no-interaction --ignore-platform-reqs --prefer-source

echo "Copy latest configuration files"
cp config/autoload/local.php.dist config/autoload/local.php
cp config/autoload/oauth2.local.php.dist config/autoload/oauth2.local.php

echo "Run phpunit tests"
phpunit -c module/Channel/test/phpunit.xml
