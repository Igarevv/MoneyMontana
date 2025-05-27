FROM nginx:alpine-slim

WORKDIR /app

COPY .docker/development/nginx/money-montana-dev.conf /etc/nginx/conf.d/money-montana.conf

COPY . /app

CMD ["nginx", "-g", "daemon off;"]