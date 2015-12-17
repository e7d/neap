#!/bin/sh

DIR=`dirname $0`

echo "Copy UnrealIRCd configuration files"
cp -R ${DIR}/resources/unrealircd/conf/* /etc/unrealircd/conf

echo "Register UnrealIRCd for auto-start"
update-rc.d unrealircd defaults

echo "Copy Anope configuration files"
cp -R ${DIR}/resources/anope/conf/* /etc/anope/conf

echo "Register Anope for auto-start"
update-rc.d anope defaults

echo "Start UnrealIRCd  with Anope services"
systemctl daemon-reload
/etc/init.d/unrealircd start
sleep 5
/etc/init.d/anope start
sleep 5

exit 0
