FROM php:8.0.7-fpm-alpine

COPY ./common/php/conf.d /usr/local/etc/php/conf.d
COPY ./dev/php/conf.d /usr/local/etc/php/conf.d
COPY ./dev/php-fpm/conf.d /usr/local/etc/php/conf.d
COPY ./dev/php-fpm/config/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN apk update \
    && apk --no-cache add \
        unzip \
        bash \
        postgresql-dev \

    && docker-php-ext-install \
        opcache \
        intl \
        pdo_pgsql \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf \
    && docker-php-source delete \
    && rm -rf /tmp/* /var/cache/apk/*

WORKDIR /app

CMD ["php-fpm", "--nodaemonize"]
