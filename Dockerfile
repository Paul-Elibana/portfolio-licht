FROM php:8.2-fpm-alpine

# Extensions PHP
RUN apk add --no-cache nginx supervisor nodejs npm \
        icu-dev icu-libs \
        libpng-dev libpng \
        libjpeg-turbo-dev libjpeg-turbo \
        freetype-dev freetype \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql bcmath opcache intl gd fileinfo \
    && apk del icu-dev libpng-dev libjpeg-turbo-dev freetype-dev

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader \
    && npm ci \
    && npm run build \
    && chown -R www-data:www-data storage bootstrap/cache

# Config nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Config supervisor (nginx + php-fpm)
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]
