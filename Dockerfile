FROM php:7.4-apache
RUN apt-get update -y && apt-get install libonig-dev -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo_mysql mbstring

# Copie os arquivos do projeto para o diretório de trabalho do contêiner
COPY . /var/www/html
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --ignore-platform-reqs
# Definir as configurações do Apache para o Laravel
COPY docker/apache2.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Definir as permissões adequadas para o diretório de armazenamento
RUN chown -R www-data:www-data storage bootstrap/cache


# Expor a porta 80 do contêiner
EXPOSE 80
