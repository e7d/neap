#!/bin/bash

try
(
	throwErrors

	echo "Copy UnrealIRCd configuration files"
	cp -R ${DIR}/resources/unrealircd/conf/* /etc/unrealircd/conf

	echo "Copy Anope configuration files"
	cp -R ${DIR}/resources/anope/conf/* /etc/anope/conf

	echo "Restart UnrealIRCd with Anope services"
	service unrealircd restart
	sleep 5 # Let Unreal breathe before Anope comes back and connects
	service anope restart
)
catch || {
	case $ex_code in
		*)
			echox "${text_red}Error:${text_reset} An unexpected exception was thrown"
			throw $ex_code
		;;
	esac
}
