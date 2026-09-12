FROM php:8.4-apache

# Instala dependências do sistema e extensões PHP necessárias ao CakePHP
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    intl \
    pdo_mysql \
    mbstring \
    gd \
    zip \
    opcache \
    && a2enmod rewrite

# Copia a aplicação para dentro do container
COPY . /var/www/html

# Define o diretório de trabalho
WORKDIR /var/www/html

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala as dependências PHP (com dev para desenvolvimento)
RUN composer install --optimize-autoloader

# Instala pdftotext (necessário para relatórios PDF)
RUN apt-get update && apt-get install -y poppler-utils

# Ajusta permissões das pastas que o CakePHP precisa escrever
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/logs \
    && chmod -R 775 /var/www/html/tmp \
    && chmod -R 775 /var/www/html/webroot

# Expõe a porta 80 do Apache
EXPOSE 80
