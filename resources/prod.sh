#!/bin/bash

. /vagrant/resources/colors.sh
. /vagrant/resources/trycatch.sh

try
(
	throwErrors

	echo "Enable OPcache"
	sed -i 's/;\?opcache.enable=.\+/opcache.enable=1/g' /etc/php/7.0/fpm/php.ini

	echo "Copy API folder"
	rm -fr /var/www/neap/api
	rsync -rltgoDh --info=progress2 /vagrant/api/ /var/www/neap/api/
	# cp -ur /vagrant/api/ /var/www/neap/api/

	echo "Setup API"
	/vagrant/bootstrap/setup-api.sh

	echo "Disable development mode"
	php /var/www/neap/api/public/index.php development disable

	echo "Copy static folder"
	rm -fr /var/www/neap/static
	rsync -rltgoDh --info=progress2 /vagrant/static/ /var/www/neap/static/
	# cp -ur /vagrant/static/ /var/www/neap/static/

	echo "Copy web folder"
	rm -fr /var/www/neap/web
	rsync -rltgoDh --info=progress2 /vagrant/web/ /var/www/neap/web/
	# cp -ur /vagrant/web/ /var/www/neap/web/

	echo "Setup Web"
	/vagrant/bootstrap/setup-web.sh

	echo "Fix Neap folders permissions"
	chown -R www-data:www-data /var/www/neap

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
