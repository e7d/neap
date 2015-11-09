#!/bin/sh

SRC=/usr/src
OPENSSL_VERSION=1.0.2d # http://www.linuxfromscratch.org/blfs/view/svn/postlfs/openssl.html

echo "Build dependencies"
apt-get -y --force-yes install build-essential libpcre3-dev libpcre++-dev \
  zlib1g-dev libcurl4-openssl-dev libssl-dev

echo "Download nginx source code"
cd ${SRC}
wget https://openssl.org/source/openssl-${OPENSSL_VERSION}.tar.gz
tar -xvzf openssl-${OPENSSL_VERSION}.tar.gz

echo "Build binaries"
cd ${SRC}/openssl-${OPENSSL_VERSION}
./config --prefix=/usr \
         --openssldir=/etc/ssl \
         --libdir=lib \
         shared \
         zlib-dynamic &&
make

echo "Install binaries"
make install

echo "Cleanup temporary files"
rm -rf ${SRC}/openssl-${OPENSSL_VERSION}*

exit 0
