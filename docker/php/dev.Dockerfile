FROM php:8.3-cli

# Set working directory
WORKDIR /app/

# Set environment variables
ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

# Install system dependencies and clear cache
RUN apt -y update \
    && apt install -y \
    libfreetype6-dev \
    libpq-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxml2-dev \
    libgmp-dev \
    libzip-dev \
    zip \
    unzip \
    postgresql-client \
    && apt clean \
    && rm -rf /var/lib/apt/lists/*

RUN groupadd -f -g $HOST_GROUP_ID $HOST_GROUP_NAME && \
    useradd -m -d /home/$HOST_USER_NAME -s /bin/bash -g $HOST_GROUP_ID -u $HOST_USER_ID $HOST_USER_NAME || true && \
    echo "$HOST_USER_NAME  ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers && \
    chown -R $HOST_USER_NAME.$HOST_GROUP_NAME /var/www/

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) iconv gd mysqli pdo_pgsql pdo_mysql soap bcmath gmp intl opcache zip exif

# Install Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy PHP config
COPY php.dev.ini /usr/local/etc/php/conf.d/zz-custom.ini

# Lauch Laravel PHP server on port 80
CMD php artisan serve --host=0.0.0.0 --port=80

# Expose port 80
EXPOSE 80
