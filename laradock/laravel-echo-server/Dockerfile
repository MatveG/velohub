FROM node:alpine

# Create main directory
RUN mkdir -p /usr/src/main
WORKDIR /usr/src/main

# Install main dependencies
COPY package.json /usr/src/main/

RUN apk add --update \
    python \
    python-dev \
    py-pip \
    build-base

RUN npm install

# Bundle main source
COPY laravel-echo-server.json /usr/src/main/laravel-echo-server.json

EXPOSE 3000
CMD [ "npm", "start", "--force" ]
