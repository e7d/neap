#!/bin/sh

DIR=`dirname $0`

# echo "Generate random fixtures"
# sudo ${DIR}/../resources/database/generate-fixtures.php;

echo "Create and populate API database"
sudo -u "postgres" psql "neap" < ${DIR}/../resources/database/fixtures.sql;

exit 0
