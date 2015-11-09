#!/bin/sh

DIR=`dirname $0`

echo "Install PostgreSQL"
apt-get -y install postgresql postgresql-contrib

echo "Create and populate API database"
sudo -u "postgres" psql "postgres" < ${DIR}/../resources/database/init.sql;
sudo -u "postgres" psql "neap" < ${DIR}/../resources/database/structure.sql;
sudo -u "postgres" psql "neap" < ${DIR}/../resources/database/oauth2.sql;
sudo -u "postgres" psql "neap" < ${DIR}/../resources/database/data.sql;

echo "Download latest Adminer"
wget https://www.adminer.org/latest-en.php -O ${DIR}/../adminer/index.php

exit 0
