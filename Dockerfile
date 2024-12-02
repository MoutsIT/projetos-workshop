# Usa a imagem oficial do PHP com Apache
FROM php:8.1-apache

# Instalar dependências
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev

# Instalar Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Instalar extensões PHP necessárias
RUN docker-php-ext-install zip

# Configurar Xdebug
RUN echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos de configuração primeiro
COPY composer.json composer.lock* ./

# Instalar dependências do projeto
RUN composer install --no-scripts --no-autoloader

# Copiar o resto dos arquivos do projeto
COPY . .

# Gerar autoloader otimizado
RUN composer dump-autoload --optimize

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html

# Expõe a porta 80
EXPOSE 80 