# ---- Etapa base con PHP 8.2 y Composer ----
FROM php:8.2-fpm

# Instalar dependencias del sistema y extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev libssl-dev libicu-dev \
    && docker-php-ext-install zip pdo_mysql bcmath intl

# Instalar Composer desde la imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo
WORKDIR /var/www

# Copiar todos los archivos del proyecto
COPY . .

# Instalar dependencias PHP (sin interacción)
RUN composer install --optimize-autoloader --no-scripts --no-interaction

# Optimizar Laravel (rutas, configuración, vistas)
RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache || true

# Exponer el puerto usado por php-fpm
EXPOSE 9000

# Iniciar el servicio PHP-FPM
CMD ["php-fpm"]
