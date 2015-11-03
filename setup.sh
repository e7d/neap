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

printf "${CYAN}Prepare environment${DEFAULT}\n"
${DIR}/config/prepare-env.sh

printf "${CYAN}Setup ffmpeg${DEFAULT}\n"
${DIR}/config/setup-ffmpeg.sh

printf "${CYAN}Build OpenSSL${DEFAULT}\n"
printf "${YELLOW}Warning:${DEFAULT} Skipped, as long as OpenSSL 1.0.2d is breaking nginx 1.9.* build\n"
sleep 2s
#${DIR}/config/build-openssl.sh

printf "${CYAN}Generate certificates${DEFAULT}\n"
${DIR}/config/generate-certificates.sh

printf "${CYAN}Build web server${DEFAULT}\n"
${DIR}/config/build-nginx.sh

printf "${CYAN}Setup PHP${DEFAULT}\n"
${DIR}/config/setup-php.sh

printf "${CYAN}Setup API${DEFAULT}\n"
${DIR}/config/setup-api.sh

printf "${CYAN}Setup database${DEFAULT}\n"
${DIR}/config/setup-db.sh
${DIR}/config/setup-fixtures.sh

printf "${CYAN}Copy project resources${DEFAULT}\n"
${DIR}/config/copy-resources.sh

printf "${CYAN}Fix permissions${DEFAULT}\n"
${DIR}/config/fix-permissions.sh

printf "${CYAN}Restart services${DEFAULT}\n"
service php5-fpm start
service nginx start

printf "${CYAN}Network adresses:${DEFAULT}\n"
echo NAT: `/sbin/ifconfig eth0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'`
echo Bridge: `/sbin/ifconfig eth1 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'`

exit 0
