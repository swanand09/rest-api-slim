# A Rest API using slim 
# Frontend VueJs

## Requirements
- PHP >= 7.2 
- Mysql >= 5.03
- Composer
- Nginx
- postman or resteasy for chrome to test api request

## Installation
- do  composer install
- execute the sql script db/book_db.sql in phpymyadmin or mysql workbench
- there is an example of a vhost conf file for nginx at `server_conf/pressbook.test.api.conf`(see its pointing to the public/index.php)
- after creating the vhost file, add `127.0.0.1 pressbook.test.api` in /etc/hosts file
- do nginx.restart
- change the configuration of the database here: `db/conf.php`
- access `http://pressbook.test.api/` on a browser

## Unit Testing
- There is a file in `unit_test/test.sh`
- run ```chmod +x test.sh``` to make it executable 
- run ```./test.sh```
