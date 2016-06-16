#!/bin/bash

. /vagrant/resources/colors.sh
. /vagrant/resources/trycatch.sh

try
(
	throwErrors

	# echo "Generate random fixtures"
	# sudo /vagrant/resources/database/generate-fixtures.php;

	echo "Import SQL file to database"
	sudo -u "postgres" psql --quiet "neap" -f /vagrant/resources/database/fixtures.sql;
)
catch || {
	case $ex_code in
		*)
			echox "${text_red}Error:${text_reset} An unexpected exception was thrown"
			throw $ex_code
		;;
	esac
}
