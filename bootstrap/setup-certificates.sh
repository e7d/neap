#!/bin/bash

. /vagrant/resources/colors.sh
. /vagrant/resources/trycatch.sh

try
(
	throwErrors

	echo "Generate a self-signed certificate"
	if [ ! -f /vagrant/resources/ssl/certificates/neap.dev.pem ] || [ ! -f /vagrant/resources/ssl/certificates/neap.dev.key ]; then
		echo "Generate a private key"
		openssl genrsa -out /vagrant/resources/ssl/certificates/neap.dev.key 4096 >/tmp/openssl.log 2>&1
		cat /tmp/openssl.log

		echo "Create the CSR file"
		openssl req -new -subj "/CN=Neap/O=Neap/C=US" -out /vagrant/resources/ssl/certificates/neap.dev.csr -key /vagrant/resources/ssl/certificates/neap.dev.key -config /vagrant/resources/ssl/openssl.cnf >/tmp/openssl.log 2>&1
		cat /tmp/openssl.log
		openssl req -text -noout -in /vagrant/resources/ssl/certificates/neap.dev.csr >/tmp/openssl.log 2>&1
		cat /tmp/openssl.log

		echo "Self-sign and create the certificate"
		openssl x509 -req -days 3650 -in /vagrant/resources/ssl/certificates/neap.dev.csr -signkey /vagrant/resources/ssl/certificates/neap.dev.key -out /vagrant/resources/ssl/certificates/neap.dev.pem -extensions v3_req -extfile /vagrant/resources/ssl/openssl.cnf >/tmp/openssl.log 2>&1
		cat /tmp/openssl.log

		echo "Package a PKCS12 file"
		echo -e "\n\n" | openssl pkcs12 -export -in /vagrant/resources/ssl/certificates/neap.dev.pem -inkey /vagrant/resources/ssl/certificates/neap.dev.key -out /vagrant/resources/ssl/certificates/neap.dev.p12 -password pass: >/tmp/openssl.log 2>&1
		cat /tmp/openssl.log
	else
		echo "skipped..."
	fi

	echo "Search for provided certificates"
	for file in /vagrant/resources/ssl/certificates/*{.crt,.pem}
	do
		if [[ -f $file ]]; then
			echo "- $file"
		fi
	done
	cp /vagrant/resources/ssl/certificates/* /etc/ssl/localcerts
)
catch || {
	case $ex_code in
		*)
			echox "${text_red}Error:${text_reset} An unexpected exception was thrown"
			throw $ex_code
		;;
	esac
}
