FROM php:7-fpm

RUN apt-get update && apt-get install -y \
        libmcrypt-dev \
        libcurl4-openssl-dev \
    && docker-php-ext-install curl opcache iconv mcrypt pdo_mysql mbstring

RUN apt-get clean
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
