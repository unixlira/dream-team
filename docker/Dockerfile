# Use a imagem base do PHP 8.0 FPM
FROM php:8.0-fpm

# Mantenedor/Criador - Contato
LABEL maintainer="José R. Lira - joserobertolira@gmail.com"

# Defina o nome de usuário e UID
ARG user=lira
ARG uid=1000

# Atualize e instale as dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libpq-dev \
    libssl-dev

# Instale as extensões PHP necessárias
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd sockets soap zip

# Instale o Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Crie um usuário de sistema para executar comandos Composer e Artisan
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Configure o diretório de trabalho
WORKDIR /var/www

# Copie o arquivo composer.json
COPY composer.json /var/www/

# Copie o restante dos arquivos do projeto
COPY . /var/www/

# Defina o usuário para o novo usuário
USER $user
