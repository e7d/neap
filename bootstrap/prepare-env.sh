#!/bin/bash

. /vagrant/resources/colors.sh
. /vagrant/resources/trycatch.sh

try
(
	throwErrors

	echo "Update dependencies"
	apt-get update

	echo "Clean outdated packages"
	apt-get -y autoremove

	echo "Add 'neap' to local resolved NS names"
	echo "127.0.0.1 neap neap.dev" >>/etc/hosts
)
catch || {
	case $ex_code in
		*)
			echox "${text_red}Error:${text_reset} An unexpected exception was thrown"
			throw $ex_code
		;;
	esac
}
