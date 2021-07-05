FROM php:8.0.7-fpm-alpine

ENV XDEBUG_VER 3.0.4

COPY ./common/php/conf.d /usr/local/etc/php/conf.d
COPY ./dev/php/conf.d /usr/local/etc/php/conf.d
COPY ./dev/php-fpm/conf.d /usr/local/etc/php/conf.d
COPY ./dev/php-fpm/config/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN apk update \
    && apk --no-cache add \
        autoconf \
        unzip \
        g++ \
        make \
        bash \
        git \
        postgresql-dev \
    && git clone --branch $XDEBUG_VER --depth 1 https://github.com/xdebug/xdebug.git /usr/src/php/ext/xdebug \
    && docker-php-ext-configure xdebug --enable-xdebug-dev \
    && docker-php-ext-install \
        intl \
        pdo_pgsql \
        xdebug \
    && mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf \
    && docker-php-source delete \
    && rm -rf /tmp/* /var/cache/apk/*

WORKDIR /app

CMD ["php-fpm", "--nodaemonize"]

COPY ./dev/php-fpm/entrypoint.sh /usr/local/bin/docker-php-entrypoint
RUN chmod +x /usr/local/bin/docker-php-entrypoint
