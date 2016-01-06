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

if [[ $@ == *"--travis"* ]]; then
	set @=$@"--coverage-clover --code-quality --coveralls --scrutinizer"
fi

if [[ $@ == *"--coverage-clover"* ]]; then
	echox "${text_cyan}Run phpunit tests with Clover code coverage"
	./vendor/bin/phpunit -c module/phpunit.xml --coverage-clover ./build/logs/coverage.xml
elif [[ $@ == *"--coverage-html"* ]]; then
	echox "${text_cyan}Run phpunit tests with HTML code coverage"
	./vendor/bin/phpunit -c module/phpunit.xml --coverage-html ./build/logs/coverage
else
	echox "${text_cyan}Run phpunit tests"
	./vendor/bin/phpunit -c module/phpunit.xml
fi

if [[ $@ == *"--code-quality"* ]]; then
	echox "${text_cyan}Check code quality"
	./vendor/bin/phpcs --standard=PSR2 module/
fi

if [[ $@ == *"--coveralls"* ]]; then
	echox "${text_cyan}Send clover log to Coveralls"
	./vendor/bin/coveralls -v -x ./build/logs/coverage.xml
fi

if [[ $@ == *"--scrutinizer"* ]]; then
	echox "${text_cyan}Send clover log to Scrutinizer"
	./vendor/bin/ocular code-coverage:upload --format=php-clover ./build/logs/coverage.xml
fi
