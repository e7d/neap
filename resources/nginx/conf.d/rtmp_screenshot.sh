#!/bin/bash

function on_die()
{
    pkill -KILL -P $$
}

trap 'on_die' TERM

channel_id=$(curl http://api.neap.dev/rtmp/translate?stream_key=$1)
echo $(date +[%FT%TZ]) take screenshot of $1 to ${channel_id} >>/var/log/nginx/screenshot.log
ffmpeg -i rtmp://localhost/transcode/$1 -updatefirst 1 -f image2 -vcodec mjpeg -vframes 1 -y /var/www/neap/static/stream/preview/${channel_id}.jpg 2> /var/log/ffmpeg/screenshot-$1.log
sleep 60s
