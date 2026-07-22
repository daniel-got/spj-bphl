# ==========================================
# STAGE 0: COMPOSER
# ==========================================
FROM docker.io/library/composer:latest AS composer

# ==========================================
# STAGE 1: BASE (Dependencies & Extensions)
# ==========================================
FROM docker.io/library/php:8.4-fpm AS base

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    libzip-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions (PostgreSQL, GD, Zip, dll)
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install Node.js (for frontend build)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Set working directory
WORKDIR /var/www/html


# ==========================================
# STAGE 2: DEVELOPMENT
# ==========================================
FROM base AS development
# Di development, kode akan di-mount dari local OS (Mac/Windows/Linux) via docker-compose.
# Sehingga kita tidak perlu COPY source code ke dalam image.
# Kita hanya perlu memastikan port terbuka.
EXPOSE 9000
CMD ["php-fpm"]


# ==========================================
# STAGE 3: PRODUCTION
# ==========================================
FROM base AS production

# Copy existing application directory contents
COPY . /var/www/html

# Set Permissions (www-data adalah user default PHP-FPM dan Nginx)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Install dependencies (Tanpa paket dev untuk efisiensi & keamanan)
USER root
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Build frontend assets
RUN npm install \
    && npm run build \
    && rm -rf node_modules

# Run PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]


# ==========================================
# STAGE 4: WEB (Nginx Production)
# ==========================================
FROM docker.io/library/nginx:alpine AS web

# Copy konfigurasi Nginx
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Copy HANYA folder public dari stage production (berisi file statis & hasil build vite)
COPY --from=production /var/www/html/public /var/www/html/public

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
