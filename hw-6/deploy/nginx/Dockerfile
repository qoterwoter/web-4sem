FROM nginx:alpine

ENV DATA_ROOT /data

WORKDIR ${DATA_ROOT}
# RUN set -x ; \
#   addgroup -g 82 -S www-data ; \
#   adduser -u 82 -D -S -G www-data www-data && exit 0 ; exit 1

# RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN mkdir -p ${DATA_ROOT}/public

COPY deploy/php-fpm/php-fpm.d /usr/local/etc/php-fpm.d
COPY .env ${DATA_ROOT}/
COPY composer.* ${DATA_ROOT}}/
COPY bin/ bin/
COPY config/ config/
COPY src/ src/
COPY public/ public/
COPY vendor/ vendor/