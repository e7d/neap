#!/bin/sh

DIR=`dirname $0`

echo "Install PostgreSQL"
apt-get -y install postgresql postgresql-contrib

echo "Create and populate API database"
# Disconnect every remaining connection
sudo -u "postgres" psql "postgres"  -c "SELECT pg_terminate_backend(pg_stat_activity.pid) FROM pg_stat_activity WHERE pg_stat_activity.datname = 'neap'";
sudo -u "postgres" psql "postgres" < ${DIR}/resources/database/init.sql;
sudo -u "postgres" psql "neap" < ${DIR}/resources/database/structure.sql;
sudo -u "postgres" psql "neap" < ${DIR}/resources/database/oauth2.sql;
sudo -u "postgres" psql "neap" < ${DIR}/resources/database/data.sql;

echo "Download latest Adminer"
wget https://www.adminer.org/latest-en.php -O ${DIR}/../adminer/index.php

exit 0
