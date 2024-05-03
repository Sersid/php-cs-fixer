FROM php:8.2-fpm

RUN apt-get update && apt-get install -y wget git unzip  \
    && apt-get install --yes --no-install-recommends libpq-dev zlib1g-dev libpng-dev libzip-dev \
    && docker-php-ext-install pdo_mysql gd zip opcache \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet --version=2.6.5

WORKDIR /var/www
