FROM php:8.4-fpm-alpine AS builder

ARG UID
ARG GID

RUN apk update && apk add --no-cache \
    git \
    zlib-dev \
    icu-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    g++ \
    curl \
    zip \
#    imagemagick \
#    imagemagick-dev \
    postgresql-dev \
    autoconf \
    make \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_pgsql pgsql opcache \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

#RUN git clone https://github.com/Imagick/imagick.git --depth 1 /tmp/imagick \
#    && cd /tmp/imagick && phpize && ./configure && make && make install \
#    && docker-php-ext-enable imagick \
#    && rm -rf /tmp/imagick

RUN mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/6.2.0.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && echo 'redis' >> /usr/src/php-available-exts \
    && docker-php-ext-install redis

FROM php:8.4-fpm-alpine AS final

ARG UID
ARG GID
ENV UID=${UID}
ENV GID=${GID}

WORKDIR /app

RUN apk update && apk add --no-cache \
#    imagemagick \
    postgresql-libs \
    git \
    unzip \
    zip \
    libpng \
    libjpeg-turbo \
    icu-libs \
    freetype \
    && rm -rf /var/lib/apt/lists/*

RUN apk --update add --virtual build-dependencies build-base openssl-dev autoconf \
  && pecl install mongodb \
  && docker-php-ext-enable mongodb \
  && apk del build-dependencies build-base openssl-dev autoconf \
  && rm -rf /var/cache/apk/*k add autoconf pkg-config libssl-dev

RUN echo "extension=mongodb.so" >> /usr/local/etc/php/php.ini

COPY --from=builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=builder /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d
COPY --from=builder /usr/local/include/php/ext /usr/local/include/php/ext
COPY --from=builder /usr/local/lib/php /usr/local/lib/php

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY . .

RUN composer install --optimize-autoloader

RUN composer dump-autoload

RUN addgroup --system --gid ${GID} laravel \
    && adduser --system --uid ${UID} --ingroup laravel --shell /bin/sh --no-create-home laravel \
    && sed -i "s/user = www-data/user = laravel/g" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i "s/group = www-data/group = laravel/g" /usr/local/etc/php-fpm.d/www.conf \
    && echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf \
    && mkdir -p /nonexistent \
    && chown -R ${UID}:${GID} /nonexistent \
    && chown -R ${UID}:${GID} /app/ \
    && chmod -R 755 /app/storage/ \
    && chmod -R 755 /app/bootstrap/cache/
COPY .docker/development/php/php.ini /usr/local/etc/php/php.ini
USER laravel

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]