#!/bin/bash

echo "Clean Aptitude"
apt-get -y -q autoremove
apt-get -y -q clean

echo "Remove all temporary files"
rm -rf /tmp/*
rm -rf /usr/src/*
rm -rf /var/tmp/*
rm -rf /var/log/*.log
rm -rf /var/log/**/*.log

# To remove history, execute the following logged in through SSH:
# cat /dev/null > ~/.bash_history && history -c && exit
