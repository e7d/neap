#!/bin/bash

function on_die()
{
    pkill -KILL -P $$
}

trap 'on_die' TERM

channel_id=$(curl http://api.neap.dev/rtmp/translate?stream_key=$1)
echo $(date +[%FT%TZ]) start transcode of \"$1\" to \"$channel_id\" >> /var/log/nginx/transcode.log
ffmpeg -i rtmp://localhost/transcode/$1 -c copy -f flv rtmp://localhost/live/$channel_id 2> /var/log/ffmpeg/transcode-$1.log &
wait
rm -rf /var/www/neap/img/screenshot_$1.jpg
echo $(date +[%FT%TZ]) stop transcode of \"$1\" to \"$channel_id\" >> /var/log/nginx/transcode.log
