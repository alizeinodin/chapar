FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

ADD . /var/www
RUN chown -R www-data:www-data /var/www

# install necessary alpine packages
RUN apk update && apk add --no-cache \
    zip \
    unzip \
    dos2unix \
    supervisor \
    libpng-dev \
    libzip-dev \
    curl-dev  \
    freetype-dev \
    $PHPIZE_DEPS \
    libjpeg-turbo-dev

RUN docker-php-ext-install pdo pdo_mysql curl zip
