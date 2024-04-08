FROM php:8.2-fpm

# Instalando dependências
RUN apt-get update && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip libpq-dev \
    && docker-php-ext-install intl opcache pdo pdo_pgsql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

# Copiando o arquivo de configuração do xdebug
COPY ./php/xdebug.ini "${PHP_INI_DIR}/conf.d/"

# Instalando o Xdebug após a instalação de todas as dependências
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

WORKDIR /var/www/project

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer