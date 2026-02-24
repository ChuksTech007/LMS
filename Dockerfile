# # FROM php:apache
# # FROM php:7.4-apache
# FROM php:8.2.12-apache

# WORKDIR /var/www/html

# # Copy your PHP application code into the container
# COPY . .

# # Install PHP extensions and other dependencies
# RUN apt-get update && \
#     apt-get install -y libpng-dev && \
#     docker-php-ext-install pdo pdo_mysql gd


# RUN docker-php-ext-install mysqli
# RUN a2enmod rewrite


# # Expose the port Apache listens on
# EXPOSE 80

# # Start Apache when the container runs
# # CMD ["apache2-foreground"]


FROM php:8.2.12-apache

WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql gd mbstring xml fileinfo bcmath \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set up Apache VirtualHost for Laravel public directory
RUN echo '<VirtualHost *:8080>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Expose port 8080 (Render will map PORT env var)
EXPOSE 8080

# Use PORT environment variable if set, otherwise default to 8080
ENV APACHE_RUN_PORT=8080
RUN sed -i 's/Listen 80/Listen ${APACHE_RUN_PORT}/g' /etc/apache2/ports.conf

CMD ["apache2-foreground"]