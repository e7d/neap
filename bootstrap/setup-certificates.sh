#!/bin/bash

. /vagrant/resources/colors.sh
. /vagrant/resources/trycatch.sh

try
(
	throwErrors

	echo "Search for provided certificates"
	# ToDo: Look inside //vagrant/bootstrap/ources/ssl for provided certificate

	echo "Try to generate \"Let's Encrypt\" certificate"
	# ToDo: Check for a valid reverse hostname to generate let's encrypt certificate
	# read -p "Domain name: " domain
	# if [ ! -z "$domain" ]
	# then
	#	 cd /usr/src
	#	 git clone https://github.com/letsencrypt/letsencrypt
	#	 cd letsencrypt
	#	 ./bootstrap/debian.sh
	#	 virtualenv --no-site-packages -p python2 venv
	#	 ./venv/bin/pip install -r requirements.txt acme/ . letsencrypt-apache/ letsencrypt-nginx/
	#	 ./venv/bin/letsencrypt --agree-eula --agree-tos --authenticator standalone -d $domain auth
	# fi
)
catch || {
	case $ex_code in
		*)
			echox "${text_red}Error:${text_reset} An unexpected exception was thrown"
			throw $ex_code
		;;
	esac
}
