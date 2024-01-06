FROM php:8.2-fpm

ARG user

RUN apt-get update && apt-get install -y \
    git \
    curl \
    vim \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    libpq-dev \
    gcc \
    make \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && docker-php-ext-install zip \
    && docker-php-source delete \
    && docker-php-ext-install pcntl

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN groupadd -g 1000 www

RUN useradd -u 1000 -ms /bin/bash -g www www

WORKDIR /var/www/app

COPY . /var/www/app

RUN composer install --ignore-platform-reqs

RUN composer dump-autoload

RUN php artisan config:cache

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug