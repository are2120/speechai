FROM php:8.3-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev nodejs npm sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

RUN touch database/database.sqlite
RUN chmod -R 775 storage bootstrap/cache database

EXPOSE 10000

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000