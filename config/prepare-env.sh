#!/bin/sh

echo "Update dependencies"
apt-get update

echo "Clean outdated packages"
apt-get -y autoremove

echo "Create records temp folder"
mkdir /var/tmp/rec

exit 0
