FROM php:8.3-fpm

# Garantir que o apt esteja instalado e configurar os repositórios
RUN apt-get update && apt-get install -y \
    apt-utils \
    curl \
    lsb-release \
    && echo "deb http://ftp.br.debian.org/debian/ $(lsb_release -cs) main" > /etc/apt/sources.list \
    && echo "deb-src http://ftp.br.debian.org/debian/ $(lsb_release -cs) main" >> /etc/apt/sources.list

# Agora, podemos prosseguir com a instalação das dependências
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    nano \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www

# Copia todos os arquivos do projeto para o container
COPY . .

# Instala as dependências PHP do projeto
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Permissões
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
