#!/bin/sh

echo "Fix web files permissions"
chmod -cR 755 /var/www/media-streaming
chown -cR www-data.root /var/www/media-streaming

echo "Fix temp files permissions"
chmod -cR 700 /var/tmp/rec
chown -cR www-data.root /var/tmp/rec

echo "Fix log files permissions"
chown -cR www-data.root /var/log/ffmpeg
chown -cR www-data.root /var/log/nginx

exit 0
