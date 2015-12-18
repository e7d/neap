#!/bin/sh

DIR=`dirname $0`

echo "Install Composer"
apt-get -y install curl
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

echo "Install dependencies"
cd ${DIR}/../api/
composer install --no-interaction --prefer-source

echo "Enable development mode"
sleep 1s
php ${DIR}/../api/public/index.php development enable

echo "Copy Neap configuration files"
cp ${DIR}/../api/config/development.config.php.dist ${DIR}/../api/config/development.config.php
cp ${DIR}/../api/config/autoload/local.php.dist ${DIR}/../api/config/autoload/local.php
cp ${DIR}/../api/config/autoload/oauth2.local.php.dist ${DIR}/../api/config/autoload/oauth2.local.php
