# Używamy oficjalnego obrazu PHP z Apache
FROM php:8.2-apache

# Ustawiamy katalog roboczy
WORKDIR /var/www/html

# Kopiujemy wszystkie pliki do katalogu www
COPY ./SRC /var/www/html/

# Zainstaluj potrzebne rozszerzenia PHP (przykład)
RUN docker-php-ext-install mysqli

# Udostępniamy port 80
EXPOSE 80
