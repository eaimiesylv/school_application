FROM php:8.1-apache

RUN apt-get update

RUN apt-get install -y \
    pkg-config \
    libzip-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev

RUN docker-php-ext-install \
    mysqli \
    pdo_mysql \
    zip

RUN apt-get install -y libgd3 libgd-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN a2enmod rewrite
RUN service apache2 restart
