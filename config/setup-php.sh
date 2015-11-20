#!/bin/sh

echo "Install PHP5 FPM"
apt-get -y install php5 php5-fpm php5-cli php5-curl php5-pgsql

echo "Disable OP Cache"
sed -i '/;opcache.enable=0/c\opcache.enable=0' /etc/php5/fpm/php.ini
service php5-fpm force-reload

exit 0
