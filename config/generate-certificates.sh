#!/bin/sh

SRC=/usr/src

echo "Generate default certificates"
mkdir -p /etc/ssl/localcerts
openssl req -new -x509 -subj "/CN=`uname -n`/O=Media Streaming/C=US" -days 3650 -nodes -out /etc/ssl/localcerts/self.pem -keyout /etc/ssl/localcerts/self.key
chmod -cR 600 /etc/ssl/localcerts/self.*

echo "Generate dhparam file"
openssl dhparam -out /etc/ssl/private/dhparam.pem 2048

exit 0
