#!/bin/bash

. /vagrant/resources/colors.sh
. /vagrant/resources/trycatch.sh

try
(
	throwErrors

	echo "Copy the gateway service binaries"
	cp /vagrant/resources/service/bin/* /etc/init.d

	ignoreErrors
	echo "Register the neap user account"
	useradd neap

	throwErrors
	echo "Fix the services permissions"
	chown -c neap.neap /etc/init.d/neap-*
	chmod -c +x /etc/init.d/neap-*

	echo "Register service scripts"
	systemctl enable neap-irc
	systemctl unmask neap-irc
	systemctl enable neap-websocket
	systemctl unmask neap-websocket
	systemctl daemon-reload

	echo "Start the Neap services"
	service neap-irc start
	service neap-websocket start
)
catch || {
	case $ex_code in
		*)
			echox "${text_red}Error:${text_reset} An unexpected exception was thrown"
			throw $ex_code
		;;
	esac
}
