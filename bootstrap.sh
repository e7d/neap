#!/bin/bash

# Start stopwatch
export BEGIN=$(date +%s)

# Store execution directory
export DIR=$(dirname `which $0`)
export SRC=/usr/src

# Load dependencies
. ${DIR}/bootstrap/resources/colors.sh
. ${DIR}/bootstrap/resources/trycatch.sh

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
    ${DIR}/bootstrap/mount-data-disk.sh

    echox "${text_cyan}Prepare Debian environment"
    ${DIR}/bootstrap/prepare-env.sh

    echox "${text_cyan}Setup structure"
    ${DIR}/bootstrap/setup-structure.sh

    echox "${text_cyan}Setup database"
    ${DIR}/bootstrap/setup-db.sh

    echox "${text_cyan}Setup API"
    ${DIR}/bootstrap/setup-api.sh

    echox "${text_cyan}Setup Web"
    ${DIR}/bootstrap/setup-web.sh

    echox "${text_cyan}Setup IRC"
    ${DIR}/bootstrap/setup-irc.sh

    echox "${text_cyan}Setup Neap service"
    ${DIR}/bootstrap/setup-service.sh

    echox "${text_cyan}Clean up"
    ${DIR}/bootstrap/cleanup.sh

    echox "${text_cyan}Network adresses"
    echo NAT: `/sbin/ifconfig eth0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'`
    echo Bridge: `/sbin/ifconfig eth1 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'`

    NOW=$(date +%s)
    DIFF=$(($NOW - $BEGIN))
    MINS=$(($DIFF / 60))
    SECS=$(($DIFF % 60))
    echox "${text_cyan}Info:${text_reset} Bootstrap lasted $MINS mins and $SECS secs"

    echox "${text_cyan}Info:${text_reset} If you need sample data, it should be inserted as root with ${DIR}/bootstrap/insert-fixtures.sh"
)
catch || {
    case $ex in
        *)
            echox "${text_red}Error:${text_reset} An unexpected exception was thrown"
            throw $ex
        ;;
    esac
}
