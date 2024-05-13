#!/bin/bash

set -e

PROJECT_DIR="/var/dev-docker"
PERMISSION_GROUP=matus

AUTHENTICATOR_PATH="${PROJECT_DIR}/scripts/authenticator-le.sh"
DOCKER_DIR="${PROJECT_DIR}/docker"
DATE_FORMAT="%Y-%m-%d"
SSL_DIR="${PROJECT_DIR}/ssl"
RENEW_BEFORE=$(date --date="+14 days" +"${DATE_FORMAT}")
SHOULD_RELOAD=0

get_issuer_cn() {
    VAR=`grep "issuer=" <<< $1`
    IFS="=" read -ra VAR <<< "$VAR"
    echo ${VAR[3]}
}

get_valid_until() {
    VAR=`grep "notAfter=" <<< $1`
    IFS="=" read -ra VAR <<< "$VAR"
    date --utc --date="${VAR[1]}" +"${DATE_FORMAT}"
}

get_subject() {
    VAR=`grep "subject=" <<< $1`
    IFS="=" read -ra VAR <<< "$VAR"
    echo ${VAR[2]}
}

run_for_path() {
    echo "Running under path ${1}..."

    for i in ${1}/*.crt; do
        [ -f "$i" ] || continue

        echo "Checking $i..."

        CERTINFO=`openssl x509 -issuer -subject -dates -noout -in $i`;
        ISSUER=$(get_issuer_cn "$CERTINFO")

        echo "[issuer $ISSUER]"

        [[ $ISSUER == *"Let's Encrypt"* ]] || continue

        VALID_UNTIL=$(get_valid_until "$CERTINFO")

        echo "[until $VALID_UNTIL]\n"

        [[ ! "${RENEW_BEFORE}" < "${VALID_UNTIL}" ]] || continue

        DOMAIN=$(get_subject "$CERTINFO")

        echo "Domain:" $DOMAIN
        echo "Valid until:" $VALID_UNTIL
        echo "Generating certificate for domain " $DOMAIN

        certbot certonly --manual \
            --manual-public-ip-logging-ok \
            --non-interactive \
            --preferred-challenges=http \
            --manual-auth-hook ${AUTHENTICATOR_PATH} \
            -d $DOMAIN -d $DOMAIN \
            || continue

        rm $PROJECT_DIR/apps/le.html

        echo "Copying certificates..."

        cp /etc/letsencrypt/live/$DOMAIN/fullchain.pem ${1}/$DOMAIN.crt
        cp /etc/letsencrypt/live/$DOMAIN/privkey.pem ${1}/$DOMAIN.key

        SHOULD_RELOAD=1
    done

    echo "Fixing permissions for path ${1}:"
    chgrp $PERMISSION_GROUP -R $1 || echo "... failed to set ownership to group $PERMISSION_GROUP."
    chmod g+rw -R $1 || echo "... failed to set permissions to read+write for group."
}

# start script
run_for_path "$SSL_DIR"

echo "Fixing permissions for letsencrypt..."
chgrp $PERMISSION_GROUP -R /var/log/letsencrypt/ /etc/letsencrypt/ /var/lib/letsencrypt/ || echo "... failed to set ownership to group $PERMISSION_GROUP."
chmod g+rw -R /var/log/letsencrypt/ /etc/letsencrypt/ /var/lib/letsencrypt/ || echo "... failed to set permissions to read+write for group."

echo "DONE."

if [ $SHOULD_RELOAD -eq 1 ]; then
    echo "Reloading nginx..."
    cd $DOCKER_DIR && docker-compose exec -T nginx nginx -s reload
else
    echo "Nothing changed."
fi
