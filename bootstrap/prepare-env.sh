#!/bin/sh

echo "Update dependencies"
apt-get update

echo "Clean outdated packages"
apt-get -y autoremove
