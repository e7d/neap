#!/bin/bash

try
(
	throwErrors

	echo "Copy PostgreSQL configuration files"
	cp -R ${DIR}/resources/postgresql/* /etc/postgresql/9.5/main

	echo "Restart PostgreSQL"
	service postgresql restart

	echo "Remove any active connection"
	sudo -u "postgres" psql "postgres" -c "SELECT pg_terminate_backend(pg_stat_activity.pid) FROM pg_stat_activity WHERE pg_stat_activity.datname = 'neap'";

	echo "Create and populate API database"
	sudo -u "postgres" psql --quiet "postgres" -f ${DIR}/resources/database/init.sql;
	sudo -u "postgres" psql --quiet "neap" -f ${DIR}/resources/database/structure.sql;
	sudo -u "postgres" psql --quiet "neap" -f ${DIR}/resources/database/oauth2.sql;
	sudo -u "postgres" psql --quiet "neap" -f ${DIR}/resources/database/data.sql;
)
catch || {
	case $ex_code in
		*)
			echox "${text_red}Error:${text_reset} An unexpected exception was thrown"
			throw $ex_code
		;;
	esac
}
