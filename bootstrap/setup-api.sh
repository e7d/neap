#!/bin/bash

try
(
	throwErrors

	echo "Install dependencies"
	cd /vagrant/api/
	composer install --no-interaction --prefer-source

	echo "Copy Neap configuration files"
	cp /vagrant/api/config/development.config.php.dist /vagrant/api/config/development.config.php
	cp /vagrant/api/config/autoload/local.php.dist /vagrant/api/config/autoload/local.php
	cp /vagrant/api/config/autoload/oauth2.local.php.dist /vagrant/api/config/autoload/oauth2.local.php

	echo "Remove cache files"
	rm -rf /vagrant/api/data/cache/*.cache.php

	echo "Enable development mode"
	sleep 1s
	php /vagrant/api/public/index.php development enable
)
catch || {
	case $ex_code in
		*)
			echox "${text_red}Error:${text_reset} An unexpected exception was thrown"
			throw $ex_code
		;;
	esac
}
