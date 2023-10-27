FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libxslt1-dev \
    curl \
    libcurl4-openssl-dev \
    libssl-dev \
    zip \
    unzip \
    git

# Configure the gd library
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Install the PHP extensions
RUN docker-php-ext-install -j$(nproc) \
    gd \
    intl \
    mbstring \
    exif \
    mysqli \
    curl \
    zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html/
COPY . /var/www/html/

RUN composer install

CMD ["php-fpm"]

EXPOSE 9000
