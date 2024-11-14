# Etapa de construcción
FROM composer:2.6 as builder
WORKDIR /app

# Copiar archivos de configuración y composer.json
COPY composer.json composer.lock ./
# Instalar las dependencias sin los dev dependencies para producción
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Etapa de aplicación
FROM php:8.2-fpm

# Instalar extensiones de PHP requeridas
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Copiar las dependencias instaladas de la etapa anterior
COPY --from=builder /app/vendor /var/www/vendor

# Copiar el código de la aplicación
COPY . /var/www

# Establecer el directorio de trabajo
WORKDIR /var/www

# Asignar permisos a la carpeta de almacenamiento y el cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Exponer el puerto 9000 para PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
