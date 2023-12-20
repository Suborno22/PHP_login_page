# Use an official PHP runtime as a base image
FROM php:8.1-apache

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html

# Install any needed packages specified in requirements.txt
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-install -j$(nproc) iconv pdo pdo_mysql mysqli gd

# Make port 80 available to the world outside this container
EXPOSE 80


# Run app.py when the container launches
CMD ["apache2-foreground"]
