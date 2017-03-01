#!/bin/bash

. /vagrant/resources/colors.sh
. /vagrant/resources/trycatch.sh

try
(
	throwErrors

	echo "Copy nginx configuration files"
	cp -R /vagrant/resources/vendor/nginx/* /etc/nginx

	echo "Enable nginx Neap sites"
	for f in /etc/nginx/sites-available/*.conf; do
		f=${f##*/}
		ln -fs /etc/nginx/sites-available/$f /etc/nginx/sites-enabled/$f
	done

	echo "Create ffmpeg operations log folder"
	mkdir -p /var/log/ffmpeg

	echo "Fix log files permissions"
	chown -cR www-data.root /var/log/nginx
	chown -cR www-data.root /var/log/ffmpeg

	echo "Restart web related services"
	service php7.1-fpm restart
	service nginx restart
)
catch || {
	case $ex_code in
		*)
			echox "${text_red}Error:${text_reset} An unexpected exception was thrown"
			throw $ex_code
		;;
	esac
}
