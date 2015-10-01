#!/bin/sh

echo "Update dependencies"
apt-get update

echo "Clean outdated packages"
apt-get -y autoremove

echo "Create web folder"
mkdir /var/www/media-streaming

echo "Create records temp folder"
mkdir /var/tmp/rec

exit 0
