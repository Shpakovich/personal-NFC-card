FROM nginx:1.21.0-alpine

RUN adduser -D -S -h /var/cache/nginx -s /sbin/nologin -G www-data www-data

COPY ./nginx.conf /etc/nginx/nginx.conf
COPY ./conf.d /etc/nginx/conf.d

WORKDIR /app
