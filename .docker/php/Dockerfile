FROM php:8.3-fpm

ENV user=user \
    uid=1000
RUN apt-get update && apt-get install -y \
    curl \
    git \
    libzip-dev \
    zip \
    cron \
    supervisor \
    sudo \
    vim \
    nano \
    libpq-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxslt-dev \
    libxml2-dev \
    locales \
    locales-all \
    tzdata \
    && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install zip \
        calendar \
        soap \
        pcntl \
        mysqli \
        pdo_mysql \
        pgsql \
        pdo_pgsql \
        opcache \
        exif \
        intl \
        xsl \
        bcmath \
        gd \
        gettext

RUN docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install -j$(nproc) gd
COPY .docker/php/php.ini /usr/local/etc/php/php.ini
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN useradd --groups=www-data,root --uid=$uid --home-dir=/home/$user $user
RUN passwd -d -u $user

RUN mkdir /home/$user && \
    chown -R $user:$user /var/www

RUN adduser $user sudo
RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers
RUN mkdir /home/$user/.composer

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
ENV TZ=Europe/Moscow
RUN cp /usr/share/zoneinfo/Europe/Moscow /etc/localtime
ENV LANG=ru_RU.UTF-8
ENV LANGUAGE=ru:en_US:en

RUN echo -e "en_US.UTF-8 UTF-8 \\nru_RU.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen
RUN mkdir -p /etc/supervisor.d/
COPY .docker/php/supervisor/supervisord.conf /etc/supervisord.conf
COPY .docker/php/supervisor/app.conf /etc/supervisor/app.conf
RUN echo "* * * * * $user php /var/www/artisan schedule:run 2>&1" >> /etc/crontab
COPY .docker/php/start.sh /usr/bin/start.sh
RUN chmod +x /usr/bin/start.sh

CMD ["sh", "/usr/bin/start.sh"]

RUN chown -R $user:$user /home/$user
COPY . /var/www/
WORKDIR /var/www/


USER $user