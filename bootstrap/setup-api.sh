#!/bin/bash

. /vagrant/resources/colors.sh
. /vagrant/resources/trycatch.sh

try
(
	throwErrors

	cd /var/www/neap/api/

	echo "Install composer dependencies"
	composer self-update
	composer install --no-interaction --ignore-platform-reqs --prefer-source

	echo "Copy Neap configuration files"
	cp /var/www/neap/api/config/development.config.php.dist /var/www/neap/api/config/development.config.php
	cp /var/www/neap/api/config/autoload/local.php.dist /var/www/neap/api/config/autoload/local.php
	cp /var/www/neap/api/config/autoload/oauth2.local.php.dist /var/www/neap/api/config/autoload/oauth2.local.php

	echo "Remove cache files"
	rm -rf /var/www/neap/api/data/cache/*.cache.php

	echo "Enable development mode"
	sleep 1s
	./vendor/bin/zf-development-mode enable
)
catch || {
	case $ex_code in
		*)
			echox "${text_red}Error:${text_reset} An unexpected exception was thrown"
			throw $ex_code
		;;
	esac
}
