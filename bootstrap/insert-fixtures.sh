#!/bin/bash

try
(
    throwErrors

    # echo "Generate random fixtures"
    # sudo ${DIR}/resources/database/generate-fixtures.php;

    echo "Import SQL file to databse"
    sudo -u "postgres" psql --quiet "neap" -f ${DIR}/bootstrap/resources/database/fixtures.sql;
)
catch || {
    case $ex_code in
        *)
            echox "${text_red}Error:${text_reset} An unexpected exception was thrown"
            throw $ex_code
        ;;
    esac
}
