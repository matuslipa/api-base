#!/bin/bash

[[ "$#" -eq 1 ]] || die "Usage: $0 <docker_root_path>"

if [[ "$1" = "" ]]
then
  echo "Usage: $0 <docker_root_path>"
  exit 1
fi

### Prepare config directory ###
CONFIG_PATH="$1/conf.d";
if [[ ! -d ${CONFIG_PATH} ]]; then
    echo "Creating configuration directory: ${CONFIG_PATH}";
    mkdir ${CONFIG_PATH};
fi

### Prepare nginx server ###
NGINX_CONFIG_PATH="${CONFIG_PATH}/nginx";
if [[ ! -d ${NGINX_CONFIG_PATH} ]]; then
    echo "Creating nginx directory: ${NGINX_CONFIG_PATH}";
    mkdir ${NGINX_CONFIG_PATH};
    cp $1/nginx/nginx.conf "${NGINX_CONFIG_PATH}/nginx.conf"
fi

NGINX_SITES_CONFIG_PATH="${NGINX_CONFIG_PATH}/sites";
if [[ ! -d ${NGINX_SITES_CONFIG_PATH} ]]; then
    echo "Creating nginx sites directory: ${NGINX_SITES_CONFIG_PATH}";
    mkdir ${NGINX_SITES_CONFIG_PATH};

    API_SITE_CONFIG_PATH="${NGINX_SITES_CONFIG_PATH}/api.localhost.conf";
    if [[ ! -f ${API_SITE_CONFIG_PATH} ]]; then
        echo "Creating api site config file: ${API_SITE_CONFIG_PATH}";
        cp $1/nginx/sites/api.conf.example ${API_SITE_CONFIG_PATH}
    fi

    PMA_SITE_CONFIG_PATH="${NGINX_SITES_CONFIG_PATH}/pma.localhost.conf";
    if [[ ! -f ${PMA_SITE_CONFIG_PATH} ]]; then
        echo "Creating nginx pma site config file: ${PMA_SITE_CONFIG_PATH}";
        cp $1/nginx/sites/pma.conf.example ${PMA_SITE_CONFIG_PATH}
    fi
fi

### Prepare SSL files ###
SSL_PATH="$1/ssl";
if [[ ! -d ${SSL_PATH} ]]; then
    echo "Creating SSL directory: ${SSL_PATH}";
    mkdir ${SSL_PATH};
fi

DEFAULT_SSL_CRT_PATH="${SSL_PATH}/default.crt";
if [[ ! -f ${DEFAULT_SSL_CRT_PATH} ]]; then
    echo "Creating default SSL certificate: ${DEFAULT_SSL_CRT_PATH}";
    cp $1/nginx/ssl/default.crt ${DEFAULT_SSL_CRT_PATH}
fi

DEFAULT_SSL_KEY_PATH="${SSL_PATH}/default.key";
if [[ ! -f ${DEFAULT_SSL_KEY_PATH} ]]; then
    echo "Creating default SSL key: ${DEFAULT_SSL_KEY_PATH}";
    cp $1/nginx/ssl/default.key ${DEFAULT_SSL_KEY_PATH}
fi

DEFAULT_SSL_DHPARAM_PATH="${SSL_PATH}/dhparam.pem";
if [[ ! -f ${DEFAULT_SSL_DHPARAM_PATH} ]]; then
    echo "Creating default dhparam: ${DEFAULT_SSL_DHPARAM_PATH}";
    cp $1/nginx/ssl/dhparam.pem ${DEFAULT_SSL_DHPARAM_PATH}
fi

### Prepare worker ###
WORKER_CONFIG_PATH="${CONFIG_PATH}/php-worker";
if [[ ! -d ${WORKER_CONFIG_PATH} ]]; then
    echo "Creating worker directory: ${WORKER_CONFIG_PATH}";
    mkdir ${WORKER_CONFIG_PATH};
    mkdir "${WORKER_CONFIG_PATH}/supervisord.d";
fi
