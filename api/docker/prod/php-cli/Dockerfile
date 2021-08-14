FROM php:8.0.7-cli-alpine

COPY ./common/php/conf.d /usr/local/etc/php/conf.d
COPY ./prod/php/conf.d /usr/local/etc/php/conf.d

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

# Install Composer
RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/usr/local/bin --filename=composer --quiet \
    && docker-php-source delete \
    && rm -rf /tmp/* /var/cache/apk/* \
    && rm -rf /root/.composer/cache

WORKDIR /app
