#syntax=docker/dockerfile:1.4
FROM php:8.2-cli-alpine

RUN mkdir -p /vol/app

WORKDIR /vol/app

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Install composer
COPY --from=composer/composer:2-bin --link /composer /usr/bin/composer
# php extensions installer: https://github.com/mlocati/docker-php-extension-installer
COPY --from=mlocati/php-extension-installer --link /usr/bin/install-php-extensions /usr/local/bin/

# Install required PHP modules and their dependencies
RUN apk add --no-cache icu icu-dev icu-libs icu-data-full libxml2 libxml2-dev pcre-dev ${PHPIZE_DEPS} linux-headers
RUN docker-php-ext-install intl ctype pdo_mysql pcntl xml soap

RUN pecl install pcov xdebug
RUN docker-php-ext-enable pcov xdebug
