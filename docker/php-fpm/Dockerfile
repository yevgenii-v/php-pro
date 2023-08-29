FROM php:8.2.3-fpm-alpine3.17

ARG GROUP_ID
ARG USER_ID
ARG COMPOSER_VERSION=2.3.10

RUN apk update
RUN apk upgrade

RUN apk add --no-cache linux-headers
RUN apk add \
    libpq-dev \
    libpng-dev \
    postgresql-dev \
    curl \
    bash \
    autoconf \
    g++ \
    make \
    supervisor \
    zip \
    libzip-dev \
    openssl-dev \
    zlib-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd \
    --enable-gd \
    && docker-php-ext-install gd

RUN docker-php-ext-install sockets
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install zip
RUN docker-php-ext-install bcmath


RUN if ! getent group www-data >/dev/null; then \
      addgroup -g ${GROUP_ID} www-data; \
    fi

RUN if ! getent passwd www-data >/dev/null; then \
      adduser -D -G www-data -u ${USER_ID} -s /bin/bash -h /home/www-data www-data; \
    fi

RUN chown -R www-data:www-data /var/www/html

RUN addgroup -g ${GROUP_ID} parent
RUN echo http://dl-2.alpinelinux.org/alpine/edge/community/ >> /etc/apk/repositories
RUN apk add -U shadow
RUN usermod -u ${USER_ID} -g ${GROUP_ID} www-data

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=${COMPOSER_VERSION}

USER www-data

CMD ["php-fpm"]
