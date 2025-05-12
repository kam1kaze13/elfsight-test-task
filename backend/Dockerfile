FROM php:8.3.12-fpm-alpine3.20

# ============================
# Install additional packages
# ============================
RUN echo https://dl-2.alpinelinux.org/alpine/edge/community/ >> /etc/apk/repositories

RUN apk update && apk add --no-cache \
    shadow \
    nano \
    git \
    bash
# ============================

# Install usermod and usermod www-data
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

#ADD ./php.ini /usr/local/etc/php/php.ini

ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# ============================
# Redis
# ============================
RUN mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/refs/tags/6.0.2.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && echo 'redis' >> /usr/src/php-available-exts
# ============================

# ============================
# PHP Extensions
# ============================
COPY --from=mlocati/php-extension-installer:2.5.1 /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions http\
    mysqli \
    pdo \
    pdo_mysql \
    soap \
    bcmath \
    sockets \
    intl \
    gd \
    amqp
# ============================

# ============================
# Composer
# ============================
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --version=2.7.0 --filename=composer
# ============================

# ============================
# CRON
# ============================
ARG CLI_CRONTAB=true

ADD ./crontab /
RUN if [ "$CLI_CRONTAB" = "false" ] ; then > /crontab; fi

RUN mkdir /var/log/cron
RUN touch /var/log/cron/cron.log
RUN chown -R www-data:www-data /var/log/cron

# Latest releases available at https://github.com/aptible/supercronic/releases
ENV SUPERCRONIC_URL=https://github.com/aptible/supercronic/releases/download/v0.2.32/supercronic-linux-amd64 \
    SUPERCRONIC=supercronic-linux-amd64 \
    SUPERCRONIC_SHA1SUM=7da26ce6ab48d75e97f7204554afe7c80779d4e0

RUN curl -fsSLO "$SUPERCRONIC_URL" \
 && echo "${SUPERCRONIC_SHA1SUM}  ${SUPERCRONIC}" | sha1sum -c - \
 && chmod +x "$SUPERCRONIC" \
 && mv "$SUPERCRONIC" "/usr/local/bin/${SUPERCRONIC}" \
 && ln -s "/usr/local/bin/${SUPERCRONIC}" /usr/local/bin/supercronic
# ============================

ADD ./php/php-fpm.d/zzz-docker.conf /usr/local/etc/php-fpm.d/zzz-docker.conf

# ============================
# PHP SPX
# ============================
COPY ./php/conf.d/php-spx.ini /usr/local/etc/php/conf.d/php-spx.ini

ARG INSTALL_PHP_SPX=true
RUN if [ ${INSTALL_PHP_SPX} = true ]; \
    then \
      apk add --no-cache zlib-dev autoconf build-base \
      && cd /usr/lib  \
      && git clone https://github.com/NoiseByNorthwest/php-spx.git  \
      && cd /usr/lib/php-spx  \
      && git checkout release/latest  \
      && phpize  \
      && ./configure  \
      && make  \
      && make install; \
    else \
      rm /usr/local/etc/php/conf.d/php-spx.ini; \
    fi;
# ============================

# ============================
# PHP XDEBUG
# ============================
COPY ./php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; \
    then \
      pecl install xdebug && docker-php-ext-enable xdebug; \
    else \
      rm /usr/local/etc/php/conf.d/xdebug.ini; \
    fi;
# ============================

WORKDIR /app

USER www-data
