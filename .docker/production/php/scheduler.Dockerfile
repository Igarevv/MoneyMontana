FROM montana/php:latest AS builder

FROM php:8.4-fpm-alpine AS final

USER root

RUN apk update && \
    apk add --no-cache \
        bash \
        curl \
        libpq \
        imagemagick \
        libgomp \
        libstdc++ \
        icu-libs && \
    curl -Lo /usr/local/bin/supercronic https://github.com/aptible/supercronic/releases/latest/download/supercronic-linux-amd64 && \
    chmod +x /usr/local/bin/supercronic && \
    rm -rf /var/cache/apk/*

WORKDIR /app

COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/ /usr/local/etc/php/
COPY --from=builder / ./

COPY .docker/development/php/crontab /etc/supercronic/laravel-cron

RUN mkdir -p /var/log && touch /var/log/cron.log

CMD ["/usr/local/bin/supercronic", "-debug", "-split-logs", "/etc/supercronic/laravel-cron"]