FROM php:fpm-alpine

RUN apk add --no-cache --update zlib-dev libmemcached-libs zlib \
    libxml2-dev \
    && docker-php-ext-install zip \
     pdo pdo_mysql mysqli opcache mbstring

RUN set -xe \
    && apk add --no-cache --update --virtual .phpize-deps $PHPIZE_DEPS \
    && pecl install -o -f redis \
    &&  docker-php-ext-enable redis \
    && rm -rf /usr/share/php7/* /var/tmp/* /usr/share/doc/* /tmp/* /tmp/pear

EXPOSE 9000

CMD ["php-fpm"]
