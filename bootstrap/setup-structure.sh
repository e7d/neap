#!/bin/bash

. /vagrant/resources/colors.sh
. /vagrant/resources/trycatch.sh

try
(
	throwErrors

	echo "Create neap folder"
	mkdir -p /var/www/neap

	echo "Link API folder"
	ln -fs /vagrant/api/ /var/www/neap/

	echo "Create database folder"
	mkdir -p /var/www/neap/db

	echo "Create RTMP folders"
	mkdir -p /data/rtmp/dash
	mkdir -p /data/rtmp/hls
	mkdir -p /data/rtmp/rec

	echo "Link RTMP folder"
	ln -fs /data/rtmp/ /var/www/neap/

	echo "Fix RTMP folders permissions"
	chmod -cR 700 /data/rtmp
	chown -cR www-data.root /data/rtmp

	echo "Link API folder"
	ln -fs /vagrant/static/ /var/www/neap/

	echo "Create static folders"
	mkdir -p /var/www/neap/static/channel/background
	mkdir -p /var/www/neap/static/channel/banner
	mkdir -p /var/www/neap/static/channel/logo
	mkdir -p /var/www/neap/static/channel/profile_banner
	mkdir -p /var/www/neap/static/channel/video_banner
	mkdir -p /var/www/neap/static/emoji
	mkdir -p /var/www/neap/static/stream/preview
	mkdir -p /var/www/neap/static/team/background
	mkdir -p /var/www/neap/static/team/banner
	mkdir -p /var/www/neap/static/team/logo
	mkdir -p /var/www/neap/static/user/logo
	mkdir -p /var/www/neap/static/video/preview

	echo "Link web folder"
	ln -fs /vagrant/web/ /var/www/neap/

	echo "Fix Neap folders permissions"
	chown -cR www-data:www-data /var/www/neap

	echo "Copy nginx configuration files"
	cp -R /vagrant/resources/nginx/* /etc/nginx

	echo "Enable nginx Neap sites"
	ln -fs /etc/nginx/sites-available/neap-api.conf /etc/nginx/sites-enabled/neap-api.conf
	ln -fs /etc/nginx/sites-available/neap-db.conf /etc/nginx/sites-enabled/neap-db.conf
	ln -fs /etc/nginx/sites-available/neap-rtmp.conf /etc/nginx/sites-enabled/neap-rtmp.conf
	ln -fs /etc/nginx/sites-available/neap-socket.conf /etc/nginx/sites-enabled/neap-socket.conf
	ln -fs /etc/nginx/sites-available/neap-static.conf /etc/nginx/sites-enabled/neap-static.conf
	ln -fs /etc/nginx/sites-available/neap-web.conf /etc/nginx/sites-enabled/neap-web.conf

	echo "Download latest Adminer"
	wget -q https://www.adminer.org/latest-en.php -O /var/www/neap/db/index.php

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
