#!/bin/bash

try
(
    throwErrors

    echo "Create RTMP folders"
    mkdir -p /data/rtmp/dash
    mkdir -p /data/rtmp/hls
    mkdir -p /data/rtmp/rec

    echo "Fix RTMP folders permissions"
    chmod -cR 700 /data/rtmp
    chown -cR www-data.root /data/rtmp

    echo "Create or link websites folders"
    mkdir -p /var/www/neap
    ln -s /vagrant/api /var/www/neap/api
    mkdir -p /var/www/neap/db
    ln -s /data/rtmp /var/www/neap/rtmp
    ln -s /vagrant/static /var/www/neap/static

    echo "Copy nginx configuration files"
    cp -R ${DIR}/bootstrap/resources/nginx/* /etc/nginx

    echo "Enable Neap sites"
    ln -s /etc/nginx/sites-available/neap-api.conf /etc/nginx/sites-enabled/neap-api.conf
    ln -s /etc/nginx/sites-available/neap-db.conf /etc/nginx/sites-enabled/neap-db.conf
    ln -s /etc/nginx/sites-available/neap-rtmp.conf /etc/nginx/sites-enabled/neap-rtmp.conf
    ln -s /etc/nginx/sites-available/neap-static.conf /etc/nginx/sites-enabled/neap-static.conf
    ln -s /etc/nginx/sites-available/neap-web.conf /etc/nginx/sites-enabled/neap-web.conf

    echo "Download latest Adminer"
    wget -q https://www.adminer.org/latest-en.php -O /var/www/neap/db/index.php

    echo "Build static folders structure"
    mkdir -p /var/www/neap/

    echo "Restart web related services"
    service php7.0-fpm restart
    service nginx restart

    echo "Create ffmpeg log folder"
    mkdir /var/log/ffmpeg

    echo "Fix log files permissions"
    chown -cR www-data.root /var/log/nginx
    chown -cR www-data.root /var/log/ffmpeg
)
catch || {
    case $ex_code in
        *)
            echox "${text_red}Error:${text_reset} An unexpected exception was thrown"
            throw $ex_code
        ;;
    esac
}
