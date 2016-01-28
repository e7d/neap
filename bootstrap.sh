#!/bin/bash

# Start stopwatch
export BEGIN=$(date +%s)

# Load dependencies
. /vagrant/resources/colors.sh
. /vagrant/resources/trycatch.sh

# This script needs admin rights
echox "${text_cyan}Check admin rights"
if [ 0 != $(id -u) ]; then
	echo_error "This script must be run as root!"
	exit 1
fi
echox "${text_green}OK"

try
(
	throwErrors

	echox "${text_cyan}Prepare data disk"
	/vagrant/bootstrap/mount-data-disk.sh

	echox "${text_cyan}Prepare Debian environment"
	/vagrant/bootstrap/prepare-env.sh

	echox "${text_cyan}Setup certificates"
	/vagrant/bootstrap/setup-certificates.sh

	echox "${text_cyan}Setup structure"
	/vagrant/bootstrap/setup-structure.sh

	echox "${text_cyan}Setup database"
	/vagrant/bootstrap/setup-db.sh

	echox "${text_cyan}Insert fixtures"
	/vagrant/bootstrap/insert-fixtures.sh

	echox "${text_cyan}Setup API"
	/vagrant/bootstrap/setup-api.sh

	echox "${text_cyan}Setup Web"
	/vagrant/bootstrap/setup-web.sh

	echox "${text_cyan}Setup IRC"
	/vagrant/bootstrap/setup-irc.sh

	echox "${text_cyan}Setup Neap service"
	/vagrant/bootstrap/setup-service.sh

	echox "${text_cyan}Clean up"
	/vagrant/bootstrap/cleanup.sh

	echox "${text_cyan}Info:${text_reset} NAT: `/sbin/ifconfig eth0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'`"
	echox "${text_cyan}Info:${text_reset} Bridge: `/sbin/ifconfig eth1 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'`"

	echox "${text_yellow}Warning:${text_reset} In order to access Neap services over SSL without issue, you need to install resources/ssl/certificates/neap.dev.p12 among the \"Trusted Root Certification Authorities\" of your system"

	NOW=$(date +%s)
	DIFF=$(($NOW - $BEGIN))
	MINS=$(($DIFF / 60))
	SECS=$(($DIFF % 60))
	echox "${text_cyan}Info:${text_reset} Bootstrap lasted $MINS mins and $SECS secs"
)
catch || {
	case $ex in
		*)
			echox "${text_red}Error:${text_reset} An unexpected exception was thrown"
			throw $ex
		;;
	esac
}
