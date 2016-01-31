#!/bin/bash

DIR=$(dirname `which $0`)

. ${DIR}/../resources/colors.sh
. ${DIR}/../resources/trycatch.sh

cd ${DIR}

for arg in "$@"
do
case $arg in
	-c|--copy-configuration)
		COPYCONFIGURATION=YES
	;;
	-h|--help)
		HELP=YES
	;;
	-f=*|--filter=*)
		FILTER="--filter ${arg#*=}"
		shift
	;;
	-l|--coveralls)
		COVERALLS=YES
	;;
	-q|--code-quality)
		CODEQUALITY=YES
	;;
	-s|--scrutinizer)
		SCRUTINIZER=YES
	;;
	-t|--travis)
		TRAVIS=YES
	;;
	-u|--composer-update)
		COMPOSERUPDATE=YES
	;;
	-v=*|--coverage=*)
		CODECOVERAGE="${arg#*=}"
		shift
	;;
	--coverage-clover)
		CODECOVERAGE="xml"
		shift
	;;
	--coverage-html)
		CODECOVERAGE="html"
		shift
	;;
	--coverage-tap)
		CODECOVERAGE="txt"
		shift
	;;
	*)
		# unknown option
	;;
esac
shift # past argument or value
done

if [[ "$HELP" == "YES" ]]; then
	echo "Usage: run-tests.sh [OPTION]..."
	echo
	echo "  -c, --copy-configuration    copy last API configuration before tests"
	echo "  -f, --filter=FILTER         use a valid PHPUnit filter"
	echo "  -l, --coveralls             upload code coverage report to Coveralls"
	echo "                                requires -x"
	echo "  -q, --code-quality          generate code quality report"
	echo "  -s, --scrutinizer           upload code quality and code coverage reports to Scrutinizer"
	echo "                                requires -q -x"
	echo "  -t, --travis                shortcut for Travis, using: -u -c -v=xml -q -l -s"
	echo "  -u, --composer-update       update Composer dependencies before tests"
	echo "  -v, --coverage=TYPE         generate code coverage report:"
	echo "                                TYPE=html for HTML output"
	echo "                                TYPE=txt for TAP (text) outpout"
	echo "                                TYPE=xml for Clover (XML) outpout"
	echo "      --coverage-clover       equivalent to --code-coverage=xml"
	echo "      --coverage-html         equivalent to --code-coverage=html"
	echo "      --coverage-tap          equivalent to --code-coverage=txt"
	echo
	exit 0
fi

if [[ "$TRAVIS" == "YES" ]]; then
	set @=$@"--composer-update --copy-configuration --coverage-clover --code-quality --coveralls --scrutinizer"
	COMPOSERUPDATE=YES
	COPYCONFIGURATION=YES
	CODECOVERAGE=xml
	CODEQUALITY=YES
	COVERALLS=YES
	SCRUTINIZER=YES
fi

try
(
	throwErrors

	if [[ "$COMPOSERUPDATE" == "YES" ]]; then
		echox "${text_cyan}Update composer"
		composer self-update
		composer install --no-interaction --ignore-platform-reqs --prefer-source
	fi

	if [[ "$COPYCONFIGURATION" == "YES" ]]; then
		echox "${text_cyan}Copy latest configuration files"
		cp -v config/autoload/local.php.dist config/autoload/local.php
		cp -v config/autoload/oauth2.local.php.dist config/autoload/oauth2.local.php
	fi

	if [[ "$CODECOVERAGE" == "xml" ]]; then
		echox "${text_cyan}Run phpunit tests with Clover code coverage"
		./vendor/bin/phpunit -c module/phpunit.xml $FILTER --coverage-clover ./build/logs/coverage.xml
	elif [[ "$CODECOVERAGE" == "html" ]]; then
		echox "${text_cyan}Run phpunit tests with HTML code coverage"
		./vendor/bin/phpunit -c module/phpunit.xml $FILTER --coverage-html ./build/logs/coverage
	elif [[ "$CODECOVERAGE" == "txt" ]]; then
		echox "${text_cyan}Run phpunit tests with TAP code coverage"
		./vendor/bin/phpunit -c module/phpunit.xml $FILTER --coverage-text=./build/logs/coverage.txt
	else
		echox "${text_cyan}Run phpunit tests"
		./vendor/bin/phpunit -c module/phpunit.xml $FILTER
	fi

	ignoreErrors

	if [[ "$CODEQUALITY" == "YES" ]]; then
		echox "${text_cyan}Check code quality"
		./vendor/bin/phpcs --standard=PSR2 module/
	fi

	if [[ "$COVERALLS" == "YES" ]]; then
		echox "${text_cyan}Send clover log to Coveralls"
		./vendor/bin/coveralls -v -x ./build/logs/coverage.xml
	fi

	if [[ "$SCRUTINIZER" == "YES" ]]; then
		echox "${text_cyan}Send clover log to Scrutinizer"
		./vendor/bin/ocular code-coverage:upload --format=php-clover ./build/logs/coverage.xml
	fi
)
catch || {
	case $ex_code in
		*)
			echox "${text_red}Error:${text_reset} An unexpected exception was thrown"
			throw $ex_code
		;;
	esac
}
