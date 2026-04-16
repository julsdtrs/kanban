FROM composer:2 AS vendor

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --optimize-autoloader

FROM node:20-alpine AS frontend

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY resources ./resources
COPY vite.config.js ./
RUN npm run build

FROM php:8.2-cli-alpine

WORKDIR /app

RUN apk add --no-cache \
    bash \
    libzip-dev \
    oniguruma-dev \
    postgresql-dev \
    sqlite-dev \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pdo_sqlite \
    mbstring \
    zip

COPY --from=vendor /app/vendor ./vendor
COPY . .
COPY --from=frontend /app/public/build ./public/build

RUN php artisan package:discover --ansi
RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan migrate --force || true

RUN mkdir -p storage/framework/{cache,sessions,views} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rwx storage bootstrap/cache

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV APP_PORT=10000

EXPOSE 10000

CMD sh -c "mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache && chmod -R 777 storage bootstrap/cache && php artisan migrate --force || true; php -S 0.0.0.0:${PORT:-${APP_PORT}} -t public"
