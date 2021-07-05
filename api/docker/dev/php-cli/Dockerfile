FROM php:8.0.7-cli-alpine

ENV XDEBUG_VER 3.0.4

COPY ./common/php/conf.d /usr/local/etc/php/conf.d
COPY ./dev/php/conf.d /usr/local/etc/php/conf.d

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

# Install Composer
RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/usr/local/bin --filename=composer --quiet \
    && docker-php-source delete \
    && rm -rf /tmp/* /var/cache/apk/* \
    && rm -rf /root/.composer/cache

WORKDIR /app
