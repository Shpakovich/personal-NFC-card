FROM php:8.0.7-cli-alpine

COPY ./docker/common/php/conf.d /usr/local/etc/php/conf.d
COPY ./docker/prod/php/conf.d /usr/local/etc/php/conf.d

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

WORKDIR /app

COPY ./ ./

RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/usr/local/bin --filename=composer --quiet \
    && docker-php-source delete \
    && rm -rf /tmp/* /var/cache/apk/*

ENV APP_ENV prod

RUN composer install --no-dev --prefer-dist --no-progress --optimize-autoloader \
    && rm -rf /root/.composer/cache \

RUN chown -R www-data:www-data ./var \
  && php bin/console cache:warmup
