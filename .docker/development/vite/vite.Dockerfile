FROM node:20.18.0-slim as base

ENV NODE_ENV=development

WORKDIR /app

FROM base as build

COPY package.json package-lock.json ./

RUN npm install

FROM base

COPY --from=build /app/node_modules /app/node_modules