#!/bin/sh

echo "Update APT definitions"
cd /tmp
wget http://www.deb-multimedia.org/pool/main/d/deb-multimedia-keyring/deb-multimedia-keyring_2015.6.1_all.deb
dpkg -i deb-multimedia-keyring_2015.6.1_all.deb
echo "deb http://www.deb-multimedia.org jessie main non-free" >/etc/apt/sources.list.d/ffmpeg.list
apt-get update

echo "Install ffmpeg"
apt-get -y install ffmpeg

exit 0
