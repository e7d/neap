#!/bin/sh

SRC=/usr/src

# ToDo: Look inside /${DIR}/resources/ssl for provided certificate
# echo "Find for provided certificates"

# ToDo: Check for a valid reverse hostname to generate let's encrypt certificate
# echo "Generate \"Let's Encrypt\" certificate"
# read -p "Domain name: " domain
# if [ ! -z "$domain" ]
# then
#     cd ${SRC}
#     git clone https://github.com/letsencrypt/letsencrypt
#     cd letsencrypt
#     ./bootstrap/debian.sh
#     virtualenv --no-site-packages -p python2 venv
#     ./venv/bin/pip install -r requirements.txt acme/ . letsencrypt-apache/ letsencrypt-nginx/
#     ./venv/bin/letsencrypt --agree-eula --agree-tos --authenticator standalone -d $domain auth
# fi

# As a backup, generate untrusted local certificate
echo "Generate self-signed certificate"
mkdir -p /etc/ssl/localcerts
openssl req -new -x509 -subj "/CN=`uname -n`/O=Neap/C=US" -days 3650 -nodes -out /etc/ssl/localcerts/self.pem -keyout /etc/ssl/localcerts/self.key
chmod -cR 600 /etc/ssl/localcerts/self.*

echo "Generate dhparam file"
openssl dhparam -out /etc/ssl/private/dhparam.pem 2048
