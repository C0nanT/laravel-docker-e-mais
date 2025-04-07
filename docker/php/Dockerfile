FROM php:8.2-fpm

# Adicione estas linhas no início
ARG USER_ID=1000
ARG GROUP_ID=1000

# Instala dependências e extensões do PHP para Laravel/PostgreSQL
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Cria usuário compatível com seu host
RUN groupadd -g ${GROUP_ID} laravel && \
    useradd -u ${USER_ID} -g laravel -m laravel && \
    chown -R laravel:laravel /var/www

USER laravel

WORKDIR /var/www