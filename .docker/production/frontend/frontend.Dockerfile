FROM node:20.18.0-slim AS node-builder

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build

FROM php:8.4-fpm-alpine

WORKDIR /app

COPY --from=node-builder /app /app

RUN apk update && apk add --no-cache \
    nodejs

CMD ["php", "artisan", "inertia:start-ssr"]