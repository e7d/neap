#!/bin/sh

# Store execution directory
DIR=`dirname $0`
# Store text colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
CYAN='\033[4;36m'
DEFAULT='\033[0m'

printf "${CYAN}Check admin rights${DEFAULT}\n"
if [ "$(id -u)" != "0" ]; then
    printf "${RED}Error:${DEFAULT} This script must be run as root!\n" 1>&2
    exit 1
fi
printf "${GREEN}Ok!${DEFAULT}\n"

printf "${CYAN}Prepare data disk${DEFAULT}\n"
${DIR}/bootstrap/mount-data-disk.sh

printf "${CYAN}Prepare Debian environment${DEFAULT}\n"
${DIR}/bootstrap/prepare-env.sh

printf "${CYAN}Setup ffmpeg${DEFAULT}\n"
${DIR}/bootstrap/setup-ffmpeg.sh

#printf "${CYAN}Build OpenSSL${DEFAULT}\n"
#printf "${YELLOW}Warning:${DEFAULT} Skipped, as long as OpenSSL 1.0.2d is breaking nginx 1.9.* build\n"
#${DIR}/bootstrap/build-openssl.sh

printf "${CYAN}Generate certificates${DEFAULT}\n"
${DIR}/bootstrap/generate-certificates.sh

printf "${CYAN}Build nginx${DEFAULT}\n"
${DIR}/bootstrap/build-nginx.sh

printf "${CYAN}Setup PHP${DEFAULT}\n"
${DIR}/bootstrap/setup-php.sh

printf "${CYAN}Setup web server${DEFAULT}\n"
${DIR}/bootstrap/setup-web.sh

printf "${CYAN}Setup API${DEFAULT}\n"
${DIR}/bootstrap/setup-api.sh

printf "${CYAN}Setup database${DEFAULT}\n"
${DIR}/bootstrap/setup-db.sh

printf "${CYAN}Insert fixtures${DEFAULT}\n"
${DIR}/bootstrap/setup-fixtures.sh

printf "${CYAN}Setup IRC${DEFAULT}\n"
${DIR}/bootstrap/setup-irc.sh

printf "${CYAN}Setup Neap service${DEFAULT}\n"
${DIR}/bootstrap/setup-service.sh

printf "${CYAN}Clean up${DEFAULT}\n"
${DIR}/bootstrap/clean.sh

printf "${CYAN}Network adresses${DEFAULT}\n"
echo NAT: `/sbin/ifconfig eth0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'`
echo Bridge: `/sbin/ifconfig eth1 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'`

exit 0
