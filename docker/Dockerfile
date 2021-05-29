FROM php:7.4-fpm

ARG APCU_VERSION=5.1.18

LABEL Maintainer="Maris Liepins" \
      Description="Kasko Homework"

RUN apt-get update && apt-get install -y \
    build-essential \
    libicu-dev \
    libzip-dev \
    locales \
    libonig-dev \
    curl \
    zip \
    unzip \
    git \
    curl \
    wget

RUN docker-php-ext-configure zip

RUN docker-php-ext-install \
        bcmath \
        mbstring \
        pcntl \
        intl \
        zip \
        opcache

RUN pecl install \
        apcu-${APCU_VERSION} \
        xdebug \
    && docker-php-ext-enable \
        apcu \
        xdebug


RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN wget https://cs.symfony.com/download/php-cs-fixer-v2.phar -O /usr/local/bin/php-cs-fixer
RUN chmod +x /usr/local/bin/php-cs-fixer

RUN apt-get update && apt-get install -y gnupg2
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update -qq && apt-get install -y yarn
RUN yarn install

COPY . /var/www
WORKDIR /var/www

ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

RUN groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN composer install --no-interaction

EXPOSE 8080

CMD ["php-fpm"]