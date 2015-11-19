#!/bin/sh

DIR=`dirname $0`

echo "Create Neap web folder"
mkdir /var/www/neap

echo "Link websites folder"
ln -s /vagrant/api /var/www/neap/api
ln -s /vagrant/adminer /var/www/neap/database
ln -s /vagrant/rtmp /var/www/neap/rtmp
ln -s /vagrant/static /var/www/neap/static

echo "Copy nginx configuration files"
cp -R ${DIR}/../resources/nginx/* /etc/nginx

echo "Enable Neap sites"
ln -s /etc/nginx/sites-available/neap-api /etc/nginx/sites-enabled/neap-api
ln -s /etc/nginx/sites-available/neap-db /etc/nginx/sites-enabled/neap-db
ln -s /etc/nginx/sites-available/neap-rtmp /etc/nginx/sites-enabled/neap-rtmp
ln -s /etc/nginx/sites-available/neap-static /etc/nginx/sites-enabled/neap-static

echo "Create ffmpeg log folder"
mkdir /var/log/ffmpeg

exit 0
