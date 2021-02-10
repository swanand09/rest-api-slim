# Pressbooks Assessment for Fullstack Dev

## Requirements
- PHP >= 7.2 
- Mysql >= 5.03
- Composer
- Nginx
- postman or resteasy for chrome to test api request

## Installation
- do  composer install
- execute the sql db/pressbooks.sql in phpymyadmin or mysql workbench
- there is a vhost conf file for nginx at server_conf/pressbook.test.api.conf
- after creating the vhost file add '127.0.0.1 pressbook.test.api' in /etc/hosts file
- do nginx.restart