FROM php:8.3-fpm-alpine
RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis.so
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer