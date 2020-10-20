#!/bin/bash
sudo service mysql stop
sudo service apache2 stop
sudo /opt/lampp/lampp start

php artisan serve
