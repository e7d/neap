#!/bin/sh

DIR=`dirname $0`
echo ${DIR}/../resources/database/structure.sql;

echo "Install PostgreSQL"
apt-get -y install postgresql

echo "Create and populate Oauth2 database"
sudo -u "postgres" psql "media-streaming" < ${DIR}/../api/vendor/zfcampus/zf-oauth2/data/db_oauth2_postgresql.sql;

echo "Create and populate API database"
sudo -u "postgres" psql "postgres" < ${DIR}/../resources/database/clean.sql;
sudo -u "postgres" psql "postgres" < ${DIR}/../resources/database/init.sql;
sudo -u "postgres" psql "media-streaming" < ${DIR}/../resources/database/structure.sql;

exit 0
