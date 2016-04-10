#!/bin/bash

. /vagrant/resources/colors.sh
. /vagrant/resources/trycatch.sh

try
(
	throwErrors

	echo "Disable OPcache"
	sed -i 's/;\?opcache.enable=.\+/opcache.enable=0/g' /etc/php/7.0/fpm/php.ini

	echo "Link API folder"
	rm -fr /var/www/neap/api
	ln -fs /vagrant/api/ /var/www/neap/

	echo "Setup API"
	/vagrant/bootstrap/setup-api.sh

	echo "Enable development mode"
	php /var/www/neap/api/public/index.php development enable

	echo "Link static folder"
	rm -fr /var/www/neap/static
	ln -fs /vagrant/static/ /var/www/neap/

	echo "Link web folder"
	rm -fr /var/www/neap/web
	ln -fs /vagrant/web/ /var/www/neap/

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
