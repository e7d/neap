#!/bin/sh

DIR=`dirname $0`

echo "Copy nginx configuration files"
cp -R ${DIR}/../resources/nginx/* /etc/nginx

echo "Create ffmpeg log folder"
mkdir /var/log/ffmpeg

exit 0
