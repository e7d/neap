#!/bin/bash

DIR=`dirname $0`

# echo "Generate random fixtures"
# sudo ${DIR}/resources/database/generate-fixtures.php;

echo "Create and populate API database"
sudo -u "postgres" psql --quiet "neap" -f ${DIR}/resources/database/fixtures.sql;
