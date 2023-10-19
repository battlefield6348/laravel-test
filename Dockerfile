# https://gitlab.com/ric_harvey/nginx-php-fpm/blob/master/docs/repo_layout.md
FROM php:8.1-fpm

WORKDIR /code

# 安裝 composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

RUN apt-get update && \
    apt-get install -y libpng-dev zlib1g-dev zlib1g-dev libzip-dev && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install gd zip
