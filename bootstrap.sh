#!/bin/sh

# Start stopwatch
BEGIN=$(date +%s)

# Store execution directory
DIR=`dirname $0`

# Load dependencies
. ${DIR}/bootstrap/resources/colors.sh

# This script needs admin rights
echo_cyan Check admin rights
if [ 0 != $(id -u) ]; then
    echo_error "This script must be run as root!"
    exit 1
fi

echo_cyan "Prepare data disk"
${DIR}/bootstrap/mount-data-disk.sh

echo_cyan "Prepare Debian environment"
${DIR}/bootstrap/prepare-env.sh

echo_cyan "Setup structure"
${DIR}/bootstrap/setup-structure.sh

echo_cyan "Setup database"
${DIR}/bootstrap/setup-db.sh

echo_cyan "Setup API"
${DIR}/bootstrap/setup-api.sh

echo_cyan "Setup Web"
${DIR}/bootstrap/setup-web.sh

echo_cyan "Setup IRC"
${DIR}/bootstrap/setup-irc.sh

echo_cyan "Setup Neap service"
${DIR}/bootstrap/setup-service.sh

echo_cyan "Clean up"
${DIR}/bootstrap/cleanup.sh

echo_cyan "Network adresses"
echo NAT: `/sbin/ifconfig eth0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'`
echo Bridge: `/sbin/ifconfig eth1 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'`

NOW=$(date +%s)
DIFF=$(($NOW - $BEGIN))
MINS=$(($DIFF / 60))
SECS=$(($DIFF % 60))
echo_info "Bootstrap lasted $MINS mins and $SECS secs"

echo_info "If you need it sample data, it should be inserted as root with ${DIR}/bootstrap/insert-fixtures.sh"

exit 0
