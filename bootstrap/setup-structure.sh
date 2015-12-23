#!/bin/bash

try
(
    throwErrors

    echo "Create neap folder"
    mkdir -p /var/www/neap

    echo "Link API folder"
    ln -s /vagrant/api /var/www/neap/api

    echo "Create database folder"
    mkdir -p /var/www/neap/db

    echo "Create RTMP folders"
    mkdir -p /data/rtmp/dash
    mkdir -p /data/rtmp/hls
    mkdir -p /data/rtmp/rec

    echo "Link RTMP folder"
    ln -s /data/rtmp /var/www/neap/rtmp

    echo "Fix RTMP folders permissions"
    chmod -cR 700 /data/rtmp
    chown -cR www-data.root /data/rtmp

    echo "Link API folder"
    ln -s /vagrant/static /var/www/neap/static

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
    ln -s /vagrant/web /var/www/neap/web

    echo "Fix Neap folders permissions"
    chown -cR www-data:www-data /var/www/neap

    echo "Copy nginx configuration files"
    cp -R ${DIR}/resources/nginx/* /etc/nginx

    echo "Enable nginx Neap sites"
    ln -s /etc/nginx/sites-available/neap-api.conf /etc/nginx/sites-enabled/neap-api.conf
    ln -s /etc/nginx/sites-available/neap-db.conf /etc/nginx/sites-enabled/neap-db.conf
    ln -s /etc/nginx/sites-available/neap-rtmp.conf /etc/nginx/sites-enabled/neap-rtmp.conf
    ln -s /etc/nginx/sites-available/neap-static.conf /etc/nginx/sites-enabled/neap-static.conf
    ln -s /etc/nginx/sites-available/neap-web.conf /etc/nginx/sites-enabled/neap-web.conf

    echo "Download latest Adminer"
    wget -q https://www.adminer.org/latest-en.php -O /var/www/neap/db/index.php

    echo "Create ffmpeg operations log folder"
    mkdir /var/log/ffmpeg

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
