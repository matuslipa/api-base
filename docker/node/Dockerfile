FROM node:16

RUN apt-get clean && apt-get update && apt-get install -y locales
RUN locale-gen C.UTF-8

ENV LANGUAGE=C.UTF-8
ENV LC_ALL=C.UTF-8
ENV LC_CTYPE=C.UTF-8
ENV LANG=C.UTF-8

RUN set -xe; \
    apt-get update -yqq && \
    apt-get install -yqq nasm

# Set default work directory
WORKDIR /var/www

EXPOSE 3000
EXPOSE 3001
