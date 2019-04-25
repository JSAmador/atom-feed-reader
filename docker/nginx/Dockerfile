FROM nginx:1.10.0-alpine

MAINTAINER Sebastian Mandrean <sebastian@urb-it.com>

ARG PHP_UPSTREAM=php-fpm
ARG UID=1000
ARG GID=1000

COPY auto-reload-nginx.sh /home/auto-reload-nginx.sh
COPY nginx.conf /etc/nginx/
COPY lumen.conf /etc/nginx/conf.d/default.conf
COPY tracking.conf /etc/nginx/conf.d/tracking.conf

RUN echo "upstream php-upstream { server ${PHP_UPSTREAM}:9000; }" > /etc/nginx/conf.d/upstream.conf \
	&& chmod +x /home/auto-reload-nginx.sh

# Install & clean up dependencies
RUN apk --no-cache --update --repository http://dl-3.alpinelinux.org/alpine/edge/community/ add \
	    curl \
	    shadow \
	    inotify-tools \
	&& apk --no-cache del \
	    wget \
	&& rm -rf /var/cache/apk/* /tmp/*

# Set up user
RUN addgroup -S www-data \
	&& adduser -D -S -h /var/cache/nginx -s /sbin/nologin -G nginx www-data \
	&& userdel -f $(getent passwd ${UID} | cut -d: -f1) || echo "no user to delete" \
	&& usermod -u ${UID} www-data \
	&& groupdel -f $(getent group ${GID} | cut -d: -f1) || echo "no group to delete" \
	&& groupmod -g ${GID} www-data

CMD ["/home/auto-reload-nginx.sh"]

WORKDIR /var/www/application

EXPOSE 80 443
