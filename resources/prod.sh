#!/bin/bash

. /vagrant/resources/colors.sh
. /vagrant/resources/trycatch.sh

try
(
	throwErrors

	echo "Copy API folder"
	rm -fr /var/www/neap/api
	cp -r /vagrant/api/ /var/www/neap/api/

	echo "Setup API"
	/vagrant/bootstrap/setup-api.sh

	echo "Disable development mode"
	php /var/www/neap/api/public/index.php development disable

	echo "Copy static folder"
	rm -fr /var/www/neap/static
	cp -r /vagrant/static/ /var/www/neap/static/

	echo "Copy web folder"
	rm -fr /var/www/neap/web
	cp -r /vagrant/web/ /var/www/neap/web/

	echo "Setup Web"
	/vagrant/bootstrap/setup-web.sh

	echo "Fix Neap folders permissions"
	chown -R www-data:www-data /var/www/neap

	echo "Enable OPcache"
	sed -i '/opcache.enable=./c\opcache.enable=1' /etc/php/7.0/fpm/php.ini

	echo "Restart PHP and nginx"
	service php7.0-fpm restart
	service nginx restart
	service neap-irc restart
	service neap-websocket restart
)
catch || {
	case $ex_code in
		*)
			echox "${text_red}Error:${text_reset} An unexpected exception was thrown"
			throw $ex_code
		;;
	esac
}
