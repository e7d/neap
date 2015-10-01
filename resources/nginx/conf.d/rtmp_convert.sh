#!/bin/bash

echo $(date +[%FT%TZ]) convert $2.flv >>/var/log/nginx/convert.log
ffmpeg -i $1/$2.flv -vcodec copy -acodec copy $1/$2.mp4 2> /var/log/ffmpeg/convert-$2.log
ffmpeg -i $1/$2.mp4 -updatefirst 1 -f image2 -vcodec mjpeg -vframes 1 -y /var/www/media-streaming/img/video_$2.jpg 2> /var/log/ffmpeg/screenshot-$2.log
rm -f $1/$2.flv
