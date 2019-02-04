FROM php:7.0-apache

# Install PHP extensions
RUN apt-get update && apt-get install -y \
      ssh \
      curl \
      less \
      vim \
      libzip-dev \
    && rm -r /var/lib/apt/lists/* \
    && docker-php-ext-install \
      intl \
      mbstring \
      mcrypt \
      zip \
      opcache


# configure gd library
#RUN docker-php-ext-configure gd \
#    --enable-gd-native-ttf \
#    --with-freetype-dir=/usr/include/freetype2

RUN docker-php-ext-install sockets


# SASS compilerusermod --shell /bin/bash
#RUN su -c "gem install sass"

RUN cd /usr/share \
    && git clone https://github.com/pear/pear-core.git pear

# Install Xdebug
RUN pecl install xdebug \
   && docker-php-ext-enable xdebug

RUN a2enmod rewrite
RUN a2enmod php7

#RUN a2ensite custom-vhost.conf
COPY build/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN touch /usr/local/etc/php/conf.d/uploads.ini \
    && echo "upload_max_filesize = 100M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 100M" >> /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /workspace/examples/src

