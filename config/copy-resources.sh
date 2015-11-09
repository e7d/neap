#!/bin/sh

DIR=`dirname $0`

echo "Create record folder"
mkdir /var/tmp/rec

echo "Create web folder"
mkdir /var/www/neap

echo "Link websites folder"
ln -s /vagrant/api /var/www/neap/api
ln -s /vagrant/adminer /var/www/neap/database

echo "Copy nginx configuration files"
cp -R ${DIR}/../resources/nginx/* /etc/nginx

echo "Enable Neap sites"
ln -s /etc/nginx/sites-available/neap-api /etc/nginx/sites-enabled/neap-api
ln -s /etc/nginx/sites-available/neap-db /etc/nginx/sites-enabled/neap-db
ln -s /etc/nginx/sites-available/neap-rtmp /etc/nginx/sites-enabled/neap-rtmp

echo "Create ffmpeg log folder"
mkdir /var/log/ffmpeg

exit 0
