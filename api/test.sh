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
./vendor/bin/phpunit -c module/phpunit.xml
# ./vendor/bin/phpunit -c module/Application/test/phpunit.xml
# ./vendor/bin/phpunit -c module/Channel/test/phpunit.xml
# ./vendor/bin/phpunit -c module/Chat/test/phpunit.xml
# ./vendor/bin/phpunit -c module/Console/test/phpunit.xml
# ./vendor/bin/phpunit -c module/Emoji/test/phpunit.xml
# ./vendor/bin/phpunit -c module/Ingest/test/phpunit.xml
# ./vendor/bin/phpunit -c module/Outage/test/phpunit.xml
# ./vendor/bin/phpunit -c module/Panel/test/phpunit.xml
# ./vendor/bin/phpunit -c module/Root/test/phpunit.xml
# ./vendor/bin/phpunit -c module/RTMP/test/phpunit.xml
# ./vendor/bin/phpunit -c module/Search/test/phpunit.xml
# ./vendor/bin/phpunit -c module/Status/test/phpunit.xml
# ./vendor/bin/phpunit -c module/Stream/test/phpunit.xml
# ./vendor/bin/phpunit -c module/Team/test/phpunit.xml
# ./vendor/bin/phpunit -c module/Topic/test/phpunit.xml
# ./vendor/bin/phpunit -c module/User/test/phpunit.xml
# ./vendor/bin/phpunit -c module/Video/test/phpunit.xml
