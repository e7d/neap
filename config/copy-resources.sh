#!/bin/sh

DIR=`dirname $0`

echo "Create Neap RTMP folders"
mkdir -p /data/rtmp/dash
mkdir -p /data/rtmp/hls
mkdir -p /data/rtmp/rec

echo "Create Neap web folder"
mkdir -p /var/www/neap

echo "Link websites folders"
ln -s /vagrant/api /var/www/neap/api
ln -s /vagrant/adminer /var/www/neap/database
ln -s /data/rtmp /var/www/neap/rtmp
ln -s /vagrant/static /var/www/neap/static

echo "Copy nginx configuration files"
cp -R ${DIR}/../resources/nginx/* /etc/nginx

echo "Enable Neap sites"
ln -s /etc/nginx/sites-available/neap-api /etc/nginx/sites-enabled/neap-api
ln -s /etc/nginx/sites-available/neap-db /etc/nginx/sites-enabled/neap-db
ln -s /etc/nginx/sites-available/neap-rtmp /etc/nginx/sites-enabled/neap-rtmp
ln -s /etc/nginx/sites-available/neap-static /etc/nginx/sites-enabled/neap-static

echo "Restart web related services"
service php7.0-fpm start
service nginx start

echo "Create ffmpeg log folder"
mkdir /var/log/ffmpeg

exit 0
