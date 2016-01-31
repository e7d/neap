#!/bin/bash

. /vagrant/resources/colors.sh
. /vagrant/resources/trycatch.sh

try
(
	throwErrors

	echo "Copy nginx configuration files"
	cp -R /vagrant/resources/nginx/* /etc/nginx

	echo "Enable nginx Neap sites"
	ln -fs /etc/nginx/sites-available/neap-api.conf /etc/nginx/sites-enabled/neap-api.conf
	ln -fs /etc/nginx/sites-available/neap-db.conf /etc/nginx/sites-enabled/neap-db.conf
	ln -fs /etc/nginx/sites-available/neap-rtmp.conf /etc/nginx/sites-enabled/neap-rtmp.conf
	ln -fs /etc/nginx/sites-available/neap-socket.conf /etc/nginx/sites-enabled/neap-socket.conf
	ln -fs /etc/nginx/sites-available/neap-static.conf /etc/nginx/sites-enabled/neap-static.conf
	ln -fs /etc/nginx/sites-available/neap-web.conf /etc/nginx/sites-enabled/neap-web.conf

	echo "Create ffmpeg operations log folder"
	mkdir -p /var/log/ffmpeg

	echo "Fix log files permissions"
	chown -cR www-data.root /var/log/nginx
	chown -cR www-data.root /var/log/ffmpeg

	echo "Restart web related services"
	service php7.0-fpm restart
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
