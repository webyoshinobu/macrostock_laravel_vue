# FROM php:7.4.1-fpm
FROM 923613491438.dkr.ecr.ap-northeast-1.amazonaws.com/macrostock_php:v_1.0

# COPY php.ini
# COPY ./docker/php/php.ini /usr/local/etc/php/php.ini

# Composer install
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

# install Node.js
COPY --from=node:10.22 /usr/local/bin /usr/local/bin
COPY --from=node:10.22 /usr/local/lib /usr/local/lib

RUN apt-get update && \
    apt-get -y install \
    git \
    zip \
    unzip \
    vim \
    && docker-php-ext-install pdo_mysql bcmath \
    # zip extentionのインストール(以下2行)エラーになるかも
    && apt-get -y install libzip-dev \ 
    && docker-php-ext-install zip

WORKDIR /var/www/html