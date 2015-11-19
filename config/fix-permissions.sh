#!/bin/sh

# echo "Fix temp files permissions"
# chmod -cR 700 /var/www/neap/rtmp
# chown -cR www-data.root /var/www/neap/rtmp

echo "Fix log files permissions"
chown -cR www-data.root /var/log/ffmpeg
chown -cR www-data.root /var/log/nginx

exit 0
