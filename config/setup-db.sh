#!/bin/sh

DIR=`dirname $0`

echo "Install PostgreSQL"
apt-get -y install postgresql

echo "Create and populate API database"
sudo -u "postgres" psql "postgres" < ${DIR}/../resources/database/init.sql;
sudo -u "postgres" psql "media-streaming" < ${DIR}/../resources/database/structure.sql;
sudo -u "postgres" psql "media-streaming" < ${DIR}/../resources/database/oauth2.sql;
sudo -u "postgres" psql "media-streaming" < ${DIR}/../resources/database/data.sql;

exit 0
