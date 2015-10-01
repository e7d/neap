#!/bin/bash

on_die ()
{
    echo $(date +[%FT%TZ]) kill transcode \"$1\" >> /var/log/nginx/transcode.log
    pkill -KILL -P $$
}

trap 'on_die' TERM
echo $(date +[%FT%TZ]) start transcode \"$1\" >> /var/log/nginx/transcode.log
ffmpeg -i rtmp://localhost/transcode/$1 -c copy -f flv rtmp://localhost/live/$1 2> /var/log/ffmpeg/transcode-$1.log &
wait
rm -rf /var/www/media-streaming/img/screenshot_$1.jpg
echo $(date +[%FT%TZ]) stop transcode \"$1\" >> /var/log/nginx/transcode.log
