# Используем официальный образ PHP 8.3 с Apache
FROM php:8.3-apache


RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    libpq-dev && \
    docker-php-ext-install pdo_pgsql


COPY . /var/www/html


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


WORKDIR /var/www/html
RUN composer install


ENV DB_HOST=localhost
ENV DB_PORT=5432
ENV DB_USER=admin
ENV DB_PASS=1111
ENV DB_NAME=postgres
ENV JWT_SECRET=keepitsecuretokenkeepitsecuretoken


EXPOSE 80
