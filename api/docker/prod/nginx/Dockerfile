FROM nginx:1.21.0-alpine

RUN adduser -D -S -h /var/cache/nginx -s /sbin/nologin -G www-data www-data

COPY ./docker/prod/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/prod/nginx/conf.d /etc/nginx/conf.d

WORKDIR /app

COPY ./public ./public
