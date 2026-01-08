# Dockerfile para despliegue en Cloud Run, Azure Container Instances, etc.
FROM php:7.4-apache

# Información del mantenedor
LABEL maintainer="tu-email@example.com"
LABEL description="Formulario de contacto con PHP y MySQL"

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar archivos del proyecto
COPY . /var/www/html/

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Copiar configuración personalizada de Apache (opcional)
# COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Exponer puerto 80
EXPOSE 80

# Configurar variables de entorno por defecto (se pueden sobrescribir)
ENV DB_HOST=localhost
ENV DB_USER=root
ENV DB_PASS=
ENV DB_NAME=formulario_contacto

# Comando de inicio
CMD ["apache2-foreground"]

