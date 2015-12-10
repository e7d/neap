#!/bin/sh

DIR=`dirname $0`

echo "Copy the gateway service binary"
cp ${DIR}/resources/service/bin/neap /etc/init.d

echo "Register the neap user account"
useradd neap

echo "Fix the service permissions"
chown -c neap.neap /etc/init.d/neap
chmod -c +x /etc/init.d/neap

echo "Register the service for auto-start"
update-rc.d neap defaults

echo "Start the Neap service"
systemctl daemon-reload
/etc/init.d/neap start
