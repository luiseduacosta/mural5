#!/bin/bash

set -e

# Detect OS
if [ -f /etc/os-release ]; then
    . /etc/os-release
    OS=$ID
else
    echo "Cannot detect OS"
    exit 1
fi

# Detect web server
if command -v apache2 >/dev/null 2>&1 || command -v httpd >/dev/null 2>&1; then
    WEBSERVER="apache"
elif command -v nginx >/dev/null 2>&1; then
    WEBSERVER="nginx"
else
    echo "No web server detected (apache/nginx)"
    exit 1
fi

# Default paths
WEBROOT="${WEBROOT:-/var/www/html}"
REPO_URL="${REPO_URL:-https://github.com/rafaelcastrocouto/mural5}"
REPO_DIR="${REPO_DIR:-mural5}"

# READ VARS
read -p "Database name: " database
read -p "Database dump location [mural5.sql]: " dump
dump=${dump:-mural5.sql}
read -p "Database username: " username
read -p "Database password: " password
read -p "Web root directory [$WEBROOT]: " input_webroot
WEBROOT=${input_webroot:-$WEBROOT}

# INSTALL PACKAGES based on OS
case $OS in
    debian|ubuntu)
        sudo apt-get -y update
        sudo apt-get -y install php php-mysql php-sqlite3 php-xml php-curl mariadb-server composer git openssl
        if [ "$WEBSERVER" = "apache" ]; then
            sudo apt-get -y install apache2 libapache2-mod-php
        else
            sudo apt-get -y install nginx php-fpm
        fi
        ;;
    fedora|rhel|centos)
        sudo dnf -y update
        sudo dnf -y install php php-mysqlnd php-sqlite3 php-xml php-curl mariadb-server composer git openssl
        if [ "$WEBSERVER" = "apache" ]; then
            sudo dnf -y install httpd mod_php
        else
            sudo dnf -y install nginx php-fpm
        fi
        ;;
    arch)
        sudo pacman -Sy --noconfirm php php-sqlite php-xml php-curl mariadb composer git openssl
        if [ "$WEBSERVER" = "apache" ]; then
            sudo pacman -S --noconfirm apache
        else
            sudo pacman -S --noconfirm nginx php-fpm
        fi
        ;;
    *)
        echo "Unsupported OS: $OS"
        exit 1
        ;;
esac

# CONFIGURE DATABASE
if [ "$OS" = "arch" ]; then
    sudo systemctl start mariadb
else
    sudo systemctl start mariadb.service
fi

echo "Running mysql_secure_installation..."
sudo mysql_secure_installation

# Generate admin password hash
ADMIN_PASSWORD="admin123"
PASSWORD_HASH=$(php -r "echo password_hash('$ADMIN_PASSWORD', PASSWORD_DEFAULT);")

# Use sudo mysql or mariadb based on OS
MYSQL_CMD="sudo mariadb"
command -v mariadb >/dev/null 2>&1 || MYSQL_CMD="sudo mysql"

$MYSQL_CMD -e "CREATE DATABASE IF NOT EXISTS \`$database\`;"
$MYSQL_CMD -e "CREATE USER IF NOT EXISTS '$username'@'localhost' IDENTIFIED BY '$password';"
$MYSQL_CMD -e "GRANT ALL PRIVILEGES ON \`$database\`.* TO '$username'@'localhost';"
$MYSQL_CMD -e "FLUSH PRIVILEGES;"

# Import schema
$MYSQL_CMD "$database" < "$dump"

# Update admin password hash
$MYSQL_CMD -e "UPDATE \`$database\`.\`users\` SET \`password\` = '$PASSWORD_HASH' WHERE \`id\` = 1;"

echo "Database configured"
echo "Default admin user: admin@ess.ufrj.br / $ADMIN_PASSWORD"

# CLONE MURAL
sudo mkdir -p "$WEBROOT"
cd "$WEBROOT"
sudo git clone "$REPO_URL" "$REPO_DIR"
echo "Repository cloned"

cd "$WEBROOT/$REPO_DIR"
composer install --no-dev --optimize-autoloader
echo "Composer dependencies installed"

# SET PERMISSIONS
HTTP_USER="www-data"
[ "$OS" = "fedora" ] || [ "$OS" = "rhel" ] || [ "$OS" = "centos" ] && HTTP_USER="apache"
[ "$OS" = "arch" ] && HTTP_USER="http"

sudo chown -R $HTTP_USER:$HTTP_USER "$WEBROOT/$REPO_DIR"
sudo chmod -R 755 "$WEBROOT/$REPO_DIR"
sudo chmod -R 775 "$WEBROOT/$REPO_DIR/tmp"
sudo chmod -R 775 "$WEBROOT/$REPO_DIR/logs"

# CONFIGURE WEB SERVER
if [ "$WEBSERVER" = "apache" ]; then
    if [ "$OS" = "fedora" ] || [ "$OS" = "rhel" ] || [ "$OS" = "centos" ]; then
        sudo systemctl enable httpd
        sudo systemctl start httpd
    else
        sudo a2enmod rewrite
        sudo systemctl restart apache2
    fi
else
    sudo systemctl enable nginx
    sudo systemctl start nginx
fi

# CREATE CONFIG FILES
ENV_FILE="$WEBROOT/$REPO_DIR/config/.env"
APP_LOCAL="$WEBROOT/$REPO_DIR/config/app_local.php"

if [ ! -f "$ENV_FILE" ]; then
    sudo cp "$WEBROOT/$REPO_DIR/config/.env.example" "$ENV_FILE"
    SALT=$(openssl rand -hex 32)
    sudo sed -i "s/__SALT__/$SALT/g" "$ENV_FILE"
    echo ".env created with new security salt"
else
    echo ".env already exists, skipping"
fi

if [ ! -f "$APP_LOCAL" ]; then
    sudo cp "$WEBROOT/$REPO_DIR/config/app_local.example.php" "$APP_LOCAL"
    sudo sed -i "s/'database' => 'my_app'/'database' => '$database'/g" "$APP_LOCAL"
    sudo sed -i "s/'username' => 'user'/'username' => '$username'/g" "$APP_LOCAL"
    sudo sed -i "s/'password' => env('PASSWORD', 'secret')/'password' => '$password'/g" "$APP_LOCAL"
    echo "app_local.php created with database credentials"
else
    echo "app_local.php already exists, skipping"
fi

echo ""
echo "======================================"
echo "Manual configuration required:"
echo "======================================"
echo "1. Verify $ENV_FILE security salt"
echo ""
echo "2. Verify $APP_LOCAL database credentials:"
echo "   'database' => '$database',"
echo "   'username' => '$username',"
echo "   'password' => '$password',"
echo ""
echo "3. Configure your web server to point to:"
echo "   $WEBROOT/$REPO_DIR/webroot"
echo "======================================"

echo "Installation complete!"
