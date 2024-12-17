FROM php:8.1-cli

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql

COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install

RUN php vendor/bin/doctrine-migrations migrate --no-interaction

RUN php seeder/script.php

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]