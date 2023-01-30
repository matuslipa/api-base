#
#--------------------------------------------------------------------------
# Image Setup
#--------------------------------------------------------------------------
#

FROM phusion/baseimage:focal-1.0.0

ENV DEBIAN_FRONTEND=noninteractive
RUN locale-gen en_US.UTF-8

ENV LANGUAGE=en_US.UTF-8
ENV LC_ALL=en_US.UTF-8
ENV LC_CTYPE=en_US.UTF-8
ENV LANG=en_US.UTF-8
ENV TERM xterm

RUN set -eux \
    # Add the "PHP 8" ppa
    && apt-get install -y software-properties-common \
    && add-apt-repository -y ppa:ondrej/php \
    #
    #--------------------------------------------------------------------------
    # Software's Installation
    #--------------------------------------------------------------------------
    #
    && echo 'DPkg::options { "--force-confdef"; };' >> /etc/apt/apt.conf \
    # Install "PHP Extentions", "libraries", "Software's"
    && apt-get update \
    && apt-get upgrade -y \
    && apt-get install -y --allow-downgrades --allow-remove-essential \
        --allow-change-held-packages \
        php8.1-cli \
        php8.1-common \
        php8.1-curl \
        php8.1-intl \
        php8.1-xml \
        php8.1-mbstring \
        php8.1-mysql \
        php8.1-pgsql \
        php8.1-sqlite \
        php8.1-sqlite3 \
        php8.1-zip \
        php8.1-bcmath \
        php8.1-memcached \
        php8.1-gd \
        php8.1-dev \
        pkg-config \
        libcurl4-openssl-dev \
        libedit-dev \
        libssl-dev \
        libxml2-dev \
        xz-utils \
        libsqlite3-dev \
        rsync \
        sqlite3 \
        git \
        curl \
        vim \
        nano \
        tree \
        postgresql-client \
    && apt-get clean \
    #####################################
    # Composer:
    #####################################
    # Install composer and add its bin to the PATH.
    && curl -s http://getcomposer.org/installer | php \
    && echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc \
    && mv composer.phar /usr/local/bin/composer

# Source the bash
RUN . ~/.bashrc

###########################################################################
# Non-root user:
###########################################################################

# Add a non-root user to prevent files being created with root permissions on host machine.
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

# always run apt update when start and after add new source list, then clean up at end.
RUN set -xe; \
    apt-get update -yqq && \
    pecl channel-update pecl.php.net && \
    groupadd -g ${PGID} simplo && \
    useradd -u ${PUID} -g simplo -m simplo -G docker_env && \
    usermod -p "*" simplo -s /bin/bash && \
    apt-get install -yqq \
      apt-utils \
      # next lines are here becase there is no auto build on dockerhub
      libzip-dev zip unzip \
      # Install the zip extension
      php8.1-zip \
      # nasm
      nasm && \
      php -m | grep -q 'zip'

###########################################################################
# xDebug:
###########################################################################

USER root

ARG INSTALL_XDEBUG=false

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
  pecl install xdebug-3.1.0 && \
  echo "zend_extension=xdebug.so" >> /etc/php/8.1/cli/conf.d/20-xdebug.ini \
;fi

# ADD for REMOTE debugging
COPY ./xdebug.ini /etc/php/8.1/cli/conf.d/xdebug.ini

RUN sed -i "s/xdebug.remote_autostart=0/xdebug.remote_autostart=1/" /etc/php/8.1/cli/conf.d/xdebug.ini && \
    sed -i "s/xdebug.remote_enable=0/xdebug.remote_enable=1/" /etc/php/8.1/cli/conf.d/xdebug.ini && \
    sed -i "s/xdebug.cli_color=0/xdebug.cli_color=1/" /etc/php/8.1/cli/conf.d/xdebug.ini

###########################################################################
# Exif:
###########################################################################

ARG INSTALL_EXIF=false

RUN if [ ${INSTALL_EXIF} = true ]; then \
    apt-get update && \
    apt-get install php8.1-exif \
;fi

###########################################################################
# PHP REDIS EXTENSION
###########################################################################

ARG INSTALL_PHPREDIS=false

RUN if [ ${INSTALL_PHPREDIS} = true ]; then \
    # Install Php Redis extension
    printf "\n" | pecl -q install -o -f redis && \
    echo "extension=redis.so" >> /etc/php/8.1/mods-available/redis.ini && \
    phpenmod redis \
;fi

###########################################################################
# Image optimizers:
###########################################################################

ARG INSTALL_IMAGE_OPTIMIZERS=false

RUN if [ ${INSTALL_IMAGE_OPTIMIZERS} = true ]; then \
    apt-get install -y jpegoptim optipng pngquant gifsicle && \
    if [ ${INSTALL_NODE} = true ]; then \
        exec bash && . ~/.bashrc && npm install -g svgo \
    ;fi\
;fi

###########################################################################
# ImageMagick:
###########################################################################

USER root

ARG INSTALL_IMAGEMAGICK=false

RUN if [ ${INSTALL_IMAGEMAGICK} = true ]; then \
    apt-get install -y imagemagick php-imagick \
;fi

###########################################################################
# Libpng16 EXTENSION
###########################################################################

ARG INSTALL_LIBPNG=false

RUN if [ ${INSTALL_LIBPNG} = true ]; then \
    apt-get update && \
    apt-get install libpng16-16 \
;fi

# Set default work directory
WORKDIR /var/www
