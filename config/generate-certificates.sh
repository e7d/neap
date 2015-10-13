#!/bin/sh

SRC=/usr/src

# echo "Generate \"Let's Encrypt\" certificates"
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

echo "Generate default certificates"
mkdir -p /etc/ssl/localcerts
openssl req -new -x509 -subj "/CN=`uname -n`/O=Neap/C=US" -days 3650 -nodes -out /etc/ssl/localcerts/self.pem -keyout /etc/ssl/localcerts/self.key
chmod -cR 600 /etc/ssl/localcerts/self.*

# ToDo: look inside /resources/ssl for provided certificates
# echo "Find for provided certificates"

echo "Generate dhparam file"
openssl dhparam -out /etc/ssl/private/dhparam.pem 2048

exit 0
