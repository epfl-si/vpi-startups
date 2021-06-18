#Download 7.2.24 version of PHP with Apache Server
#PHP image with apache included
FROM php:7.2.24-apache

# Update the image to the latest packages and install vim
RUN apt-get update && apt-get upgrade -y && apt-get install vim libldap2-dev -y 

# Install ldap and docker php module to image
RUN docker-php-ext-configure ldap

#Install and start mysqli and pdo for read and write in the database with PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql ldap

#Add rewrite module to image
RUN a2enmod rewrite