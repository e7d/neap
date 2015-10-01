#!/bin/sh

SRC=/usr/src
NGINX_VERSION=1.9.5 # http://nginx.org/en/download.html

echo "Build dependencies"
apt-get -y --force-yes install curl git build-essential libpcre3-dev libpcre++-dev \
  zlib1g-dev libcurl4-openssl-dev libssl-dev nginx

echo "Download nginx source code"
cd ${SRC}
wget http://nginx.org/download/nginx-${NGINX_VERSION}.tar.gz
tar -xvzf nginx-${NGINX_VERSION}.tar.gz

echo "Download nginx-rtmp-module source code"
cd ${SRC}
git clone --progress https://github.com/arut/nginx-rtmp-module.git

echo "Build binaries"
cd ${SRC}/nginx-${NGINX_VERSION}
./configure --prefix=/var/www \
            --sbin-path=/usr/sbin/nginx \
            --conf-path=/etc/nginx/nginx.conf \
            --pid-path=/var/run/nginx.pid \
            --error-log-path=/var/log/nginx/error.log \
            --http-log-path=/var/log/nginx/access.log \
            --with-file-aio \
            --with-http_ssl_module \
            --with-http_v2_module \
            --with-http_realip_module \
            --with-http_addition_module \
            --with-http_sub_module \
            --with-http_dav_module \
            --with-http_flv_module \
            --with-http_mp4_module \
            --with-http_gunzip_module \
            --with-http_gzip_static_module \
            --with-http_random_index_module \
            --with-http_secure_link_module \
            --with-http_stub_status_module \
            --with-ipv6 \
            --with-mail \
            --with-mail_ssl_module \
            --add-module=${SRC}/nginx-rtmp-module &&
make

echo "Stop running service"
service nginx stop

echo "Install binaries"
make install

echo "Prepare environment for first start"
mkdir -p /var/www
cp html/* /var/www

echo "Cleanup temporary files"
rm -rf ${SRC}/nginx-${NGINX_VERSION}*
rm -rf ${SRC}/nginx-rtmp-module*

exit 0
