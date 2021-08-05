FROM php:7.1-fpm-stretch

ENV WORKDIR=/app

RUN apt-get update \
    && apt-get install -y \
    libpq-dev \
    zlib1g-dev \
    zip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql zip \
    && date > /builddate;

WORKDIR $WORKDIR

COPY ./ ./

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

COPY docker/php/change.ini /usr/local/etc/php/conf.d/change.ini