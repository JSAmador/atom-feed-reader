FROM php:7.1-alpine

ARG UID=1000
ARG GID=1000

MAINTAINER Sebastian Mandrean <sebastian@urb-it.com>

ENV MONGODB_VERSION=1.2.5

# Install dependencies & clean up
RUN apk --no-cache --update --repository http://dl-3.alpinelinux.org/alpine/edge/community/ add \
    php7-sockets \
    php7-bcmath \
    curl \
    openssl-dev \
    openssl \
    autoconf \
    build-base \
    icu \
    icu-dev \
&& apk --no-cache del \
    wget
RUN pecl install \
    mongodb-$MONGODB_VERSION \
&& docker-php-ext-install \
    pdo_mysql \
    sockets \
    intl \
    bcmath \
&& docker-php-ext-enable \
    mongodb

RUN rm -rf /var/cache/apk/* /tmp/* \
&& apk --no-cache del \
    build-base \
    autoconf \
    openssl-dev \
    icu-dev

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --install-dir="/usr/local/bin" --filename="composer" \
    && php -r "unlink('composer-setup.php');"

# Add config & crontab
ADD ./lumen.ini /usr/local/etc/php/conf.d
ADD lumen-scheduler.crontab /lumen-scheduler.crontab
RUN /usr/bin/crontab /lumen-scheduler.crontab

WORKDIR /var/www/application

RUN apk --no-cache add shadow \
    && userdel -f $(getent passwd ${UID} | cut -d: -f1) || echo "no user to delete" \
    && usermod -u ${UID} www-data \
    && groupdel -f $(getent group ${GID} | cut -d: -f1) || echo "no group to delete" \
    && groupmod -g ${GID} www-data

USER www-data
