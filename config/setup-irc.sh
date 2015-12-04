#!/bin/sh

DIR=`dirname $0`

echo "Download UnrealIRCd sources"
cd /usr/src
wget --no-check-certificate --trust-server-names https://www.unrealircd.org/downloads/Unreal3.4-latest.tar.gz
tar xzvf unreal*.tar.gz
cd unreal*

echo "Build UnrealIRCd"
rm -fr /etc/unrealircd/
cp -R ${DIR}/../resources/irc/unrealircd/src/* .
chmod +x config.settings
./config.settings
./Config -nointro -quick
make
make install

echo "Copy UnrealIRCd configuration files"
cp -R ${DIR}/../resources/irc/unrealircd/conf/* /etc/unrealircd/conf

echo "Copy UnrealIRCd service script"
cp ${DIR}/../resources/irc/unrealircd/bin/unrealircd /etc/init.d

echo "Fix UnrealIRCd permissions"
chown -cR irc.irc /etc/unrealircd
chown -c irc.irc /etc/init.d/unrealircd
chmod -c +x /etc/init.d/unrealircd

echo "Register UnrealIRCd for auto-start"
update-rc.d unrealircd defaults

echo "Download Anope dependencies"
apt-get install -y cmake

echo "Download Anope sources"
cd /usr/src
wget https://github.com/anope/anope/releases/download/2.0.2/anope-2.0.2-source.tar.gz
tar xzvf anope-2.0.2-source.tar.gz
cd anope*

echo "Build Anope"
rm -fr /etc/anope/
cp -R ${DIR}/../resources/irc/anope/src/* .
./Config -nointro -quick
cd build
make
make install

echo "Copy Anope configuration files"
cp -R ${DIR}/../resources/irc/anope/conf/* /etc/anope/conf

echo "Copy Anope service script"
cp ${DIR}/../resources/irc/anope/bin/anope /etc/init.d

echo "Fix Anope permissions"
chown -cR irc.irc /etc/anope
chown -c irc.irc /etc/init.d/anope
chmod -c +x /etc/init.d/anope

echo "Register Anope for auto-start"
update-rc.d anope defaults

echo "Set bash access to 'irc' account"
chsh -s /bin/bash irc

echo "Start UnrealIRCd  with Anope services"
systemctl daemon-reload
/etc/init.d/unrealircd start
sleep 5
/etc/init.d/anope start
sleep 5

exit 0
