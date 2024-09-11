#!/bin/bash

# chmod +x install.sh

# READ VARS

echo -e "database name?"
read database

echo -e "database dump location?"
read dump

echo -e "username?"
read username

echo -e "password?"
read password

# INSTALL PACKAGES

#sudo do-release-upgrade
sudo apt-get -y update
sudo apt-get -y dist-upgrade
sudo apt -y install software-properties-common php php-common php-mysql php-sqlite3 php-xml mariadb-server composer
sudo apt-get -y install php-curl

#sudo add-apt-repository ppa:ondrej/php
#sudo add-apt-repository ppa:ondrej/apache2
#sudo apt install php7.1
#echo -e "choose php7.1"
#sudo update-alternatives --config php

# CONFIGURE DATABASE

sudo systemctl start mariadb.service
echo -e "[y] unix socket [n] change password [y] remove users [y] login remote [y] reload tables"
read
sudo mysql_secure_installation

sudo mariadb -e "CREATE DATABASE $database;"
sudo mariadb -e "CREATE USER IF NOT EXISTS '$username'@'%' IDENTIFIED BY '$password'"
sudo mariadb -e "GRANT ALL PRIVILEGES ON *.* TO '$username'@'%' WITH GRANT OPTION;"
sudo mariadb -e "FLUSH PRIVILEGES;"
sudo mariadb $database < $dump
echo "mariadb database configured"

# CLONE MURAL

cd /var/www/html
git clone "https://github.com/rafaelcastrocouto/mural4"
echo "mural repository cloned"

cd /var/www/html/mural4
composer update
echo "composer requirements installed"

# SET USERS PERMISSIONS

sudo chown -R www-data /var/www/html
sudo usermod -a -G www-data $username
sudo chmod -R a+w /var/www/html

# EDIT APACHE CONF PERMISSION

echo nano /etc/apache2/apache2.conf
echo "<Directory /var/www>"
echo "	Options Indexes FollowSymLinks"
echo "	AllowOverride All <<<<<<<< CHANGE THIS"
echo "	Require all granted"
echo "</Directory>"
echo -e "enter to proceed to nano"
read
sudo nano /etc/apache2/apache2.conf

# SET APACHE ROOT DIR

echo nano /etc/apache2/sites-available/000-default.conf
echo "DocumentRoot /var/www/html/mural4/webroot <<<<<<<< CHANGE THIS"
echo -e "enter to proceed to nano"
read
sudo nano /etc/apache2/sites-available/000-default.conf

# CREATE CONFIG .ENV

sudo cp /var/www/html/mural4/config/.env.example /var/www/html/mural4/config/.env
echo "export SECURITY_SALT="12345678901234567890123456789012" <<<<<<<< CHANGE THIS"
echo "export PASSWORD => "$password", <<<<<<<< CHANGE THIS"
echo -e "enter to proceed to nano"
read
sudo nano /var/www/html/mural/config/.env

# CREATE CONFIG app_local.php

sudo cp /var/www/html/mural4/config/app_local.example.php /var/www/html/mural4/config/app_local.php
echo "'database' => '"$database"', <<<<<<<< CHANGE THIS"
echo "'username' => '"$username"', <<<<<<<< CHANGE THIS"
echo -e "enter to proceed to nano"
read
sudo nano /var/www/html/mural/config/app_local.php

# CONFIG APACHE MOD REWRITE

sudo a2enmod rewrite
echo "mod rewrite configured"
sudo systemctl restart apache2
echo "systemctl apache server restarted"
