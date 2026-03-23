FROM php:8.2.12-apache

WORKDIR /var/www/html

# Install system dependencies + Node.js 20
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_mysql gd mbstring xml fileinfo bcmath \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Install pnpm
RUN npm install -g pnpm

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy dependency manifests first (better Docker layer caching)
COPY composer.json composer.lock ./
COPY package.json pnpm-lock.yaml* package-lock.json* ./

# Install Node dependencies and build frontend assets
COPY resources/ ./resources/
COPY vite.config.js tailwind.config.js postcss.config.js* ./
RUN pnpm install --frozen-lockfile || npm install
RUN pnpm run build || npm run build

# Copy the rest of the application
COPY . .

# Install PHP dependencies (no dev, optimised autoloader)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set Apache VirtualHost to serve from /public on port 8080
RUN echo '<VirtualHost *:8080>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
        Options -Indexes\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Update Apache to listen on 8080
RUN sed -i 's/Listen 80/Listen 8080/g' /etc/apache2/ports.conf

# Set correct permissions for Laravel writable directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create startup script: link storage, run migrations, then start Apache
RUN printf '#!/bin/bash\nset -e\n\nphp artisan storage:link --force\nphp artisan migrate --force\nphp artisan config:cache\nphp artisan route:cache\nphp artisan view:cache\n\nexec apache2-foreground\n' > /start.sh \
    && chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]
