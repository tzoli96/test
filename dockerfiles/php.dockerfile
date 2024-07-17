FROM php:8.3-fpm-alpine

ARG UID=1000
ARG GID=1000

ENV UID=${UID}
ENV GID=${GID}

# Install dependencies
RUN apk --no-cache add \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libwebp-dev \
        libxpm-dev \
        zip \
        libzip-dev \
        gd \
    && docker-php-ext-configure gd \
        --with-freetype=/usr/include/ \
        --with-jpeg=/usr/include/ \
        --with-webp=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd zip pdo pdo_mysql

# Create laravel user with appropriate UID and GID
RUN addgroup -g ${GID} --system laravel \
    && adduser -u ${UID} -G laravel --system -D -s /bin/sh laravel

# Set working directory
WORKDIR /var/www/html

# Copy Composer binary from composer image
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Adjust permissions for storage and logs directories
RUN mkdir -p storage/framework/views storage/logs bootstrap/cache \
    && chown -R laravel:laravel storage bootstrap/cache

# Adjust PHP-FPM configuration
RUN sed -i "s/user = www-data/user = laravel/g" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i "s/group = www-data/group = laravel/g" /usr/local/etc/php-fpm.d/www.conf \
    && echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

# Copy entrypoint script from dockerfiles directory
COPY ./dockerfiles/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

# Ensure the entrypoint script is executable
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Change ownership and permissions
RUN chown -R laravel:laravel /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Switch to laravel user
USER laravel

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
