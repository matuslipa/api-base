#!/bin/bash

set -e

if [[ "$1" = "" ]]
then
  echo "Usage: $0 <domain>"
  exit 1
fi

PROJECT_DIR="/var/dev-docker";
PERMISSION_GROUP=simplo

echo "Generating certificate for domain: $1"

certbot certonly --manual --preferred-challenges=http --manual-auth-hook ${PROJECT_DIR}/scripts/authenticator-le.sh -d $1 -d $1

rm $PROJECT_DIR/apps/le.html

cp /etc/letsencrypt/live/$1/fullchain.pem ${PROJECT_DIR}/ssl/$1.crt
cp /etc/letsencrypt/live/$1/privkey.pem ${PROJECT_DIR}/ssl/$1.key

chgrp $PERMISSION_GROUP -R ${PROJECT_DIR}/ssl/$1.* || echo "... failed to set ownership to group $PERMISSION_GROUP."
chmod g+rw -R ${PROJECT_DIR}/ssl/$1.* || echo "... failed to set permissions to read+write for group."

cd ${PROJECT_DIR}/docker
docker-compose exec nginx nginx -s reload
