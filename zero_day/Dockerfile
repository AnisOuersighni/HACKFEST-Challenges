# Use an official PHP runtime as a parent image with Apache
FROM php:7.4-apache

# Install necessary dependencies for PHP to communicate with MariaDB
RUN apt-get update && apt-get install -y \
    mariadb-client \
    && docker-php-ext-install mysqli pdo pdo_mysql


# Copy the application files into the container
COPY ./src/www /var/www/html

#COPY ./database/init_db.sql /tmp/init_db.sql

COPY ./flag.txt /lotus/flag.txt

RUN chmod 555 /lotus/flag.txt

# Use the default PHP development configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"


# Set permissions for the copied application files
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 for the web server
EXPOSE 80

# Set the command to start Apache in the foreground (this will keep the container running)
CMD ["apache2-foreground"]
