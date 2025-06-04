FROM nginx:alpine-slim

WORKDIR /app

COPY .docker/production/nginx/money-montana-prod.conf /etc/nginx/conf.d/money-montana.conf

COPY . /app

CMD ["nginx", "-g", "daemon off;"]