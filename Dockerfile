FROM alpine:edge

# Add basics first
RUN apk update && apk upgrade && apk add \
	bash curl && \
	apk add \
    php7-cli \
    php7-iconv \
    php7-phar \
    php7-json \
    php7-iconv \
    php7-openssl \
    php7-zip \
    php7-curl \
    php7-tokenizer \
    php7-ctype \
    php7-mbstring \
    php7-xml \
    php7-xmlreader \
    php7-xmlwriter \
    php7-simplexml \
    php7-session \
    php7-pdo \
    rm -f /var/cache/apk/*

# Add Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

ARG APP_UID=501
ARG APP_GID=501

RUN addgroup --gid $APP_GID -S app && adduser --uid $APP_UID -S -H -G app -h /app app

RUN mkdir /app && mkdir /app/public && chown -R app:app /app && chmod -R 755 /app && mkdir bootstrap

EXPOSE 8000
WORKDIR /app/

USER app
COPY --chown=app:app . ./
RUN APP_ENV=prod composer install --no-dev && \
    composer dump-env prod

CMD php -S 0.0.0.0:8000 -t public

