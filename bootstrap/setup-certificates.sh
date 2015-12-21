#!/bin/bash

export SRC=/usr/src

# ToDo: Look inside /${DIR}/bootstrap/ources/ssl for provided certificate
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
