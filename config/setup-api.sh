#!/bin/sh

DIR=`dirname $0`

echo "Install dependencies"
apt-get -y install curl

echo "Link website folder to api folder"
ln -s ${DIR}/../api /var/www/media-streaming

echo "Install Composer"
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

echo "Config GitHub token for Composer"
composer config -g github-oauth.github.com 580e2e62379b697dd8c0f131ac9b9807f2119e07

echo "Install Apigility"
# composer create-project -sdev zfcampus/zf-apigility-skeleton ${DIR}/../api/
cd ${DIR}/../api/
composer update

echo "Enable development mode"
sleep 1s
php ${DIR}/../api/public/index.php development enable

exit 0
