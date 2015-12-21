#!/bin/bash

DIR=`dirname $0`

echo "Copy UnrealIRCd configuration files"
cp -R ${DIR}/resources/unrealircd/conf/* /etc/unrealircd/conf

echo "Copy Anope configuration files"
cp -R ${DIR}/resources/anope/conf/* /etc/anope/conf

echo "Restart UnrealIRCd with Anope services"
service unrealircd restart
sleep 5 # Let Unreal breathe before Anope comes back and connects
service anope restart
