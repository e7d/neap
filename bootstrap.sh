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
    echo_error "This script must be as root!"
    exit 1
fi

echo_cyan "Prepare data disk"
${DIR}/bootstrap/mount-data-disk.sh

echo_cyan "Prepare Debian environment"
${DIR}/bootstrap/prepare-env.sh

echo_cyan "Setup ffmpeg"
${DIR}/bootstrap/setup-ffmpeg.sh

echo_cyan "Build OpenSSL"
echo_warning "Skipped, as long as OpenSSL 1.0.2d is breaking nginx 1.9.* build"
sleep 5
#${DIR}/bootstrap/build-openssl.sh

echo_cyan "Generate certificates"
${DIR}/bootstrap/generate-certificates.sh

echo_cyan "Build nginx"
${DIR}/bootstrap/build-nginx.sh

echo_cyan "Setup PHP"
${DIR}/bootstrap/setup-php.sh

echo_cyan "Setup web server"
${DIR}/bootstrap/setup-web.sh

echo_cyan "Setup API"
${DIR}/bootstrap/setup-api.sh

echo_cyan "Setup database"
${DIR}/bootstrap/setup-db.sh

echo_cyan "Insert fixtures"
${DIR}/bootstrap/setup-fixtures.sh

echo_cyan "Setup IRC"
${DIR}/bootstrap/setup-irc.sh

echo_cyan "Setup Neap service"
${DIR}/bootstrap/setup-service.sh

echo_cyan "Clean up"
${DIR}/bootstrap/clean.sh

echo_cyan "Network adresses"
echo_info NAT: `/sbin/ifconfig eth0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'`
echo_info Bridge: `/sbin/ifconfig eth1 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'`

NOW=$(date +%s)
DIFF=$(($NOW - $BEGIN))
MINS=$(($DIFF / 60))
SECS=$(($DIFF % 60))
echo_info "Startup duration: $MINS mins and $SECS secs"

exit 0
