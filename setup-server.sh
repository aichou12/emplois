#!/usr/bin/env bash

# ==============================================================================
# SCRIPT DE PROVISIONING ET DÉPLOIEMENT COMPLET DEPUIS ZÉRO (FRESH SERVER)
# Projet : Plateforme PGDE (Laravel 11 / PHP 8.2 / Nginx / MySQL)
# Compatible : Ubuntu 22.04 LTS / Ubuntu 24.04 LTS / Debian 12
# ==============================================================================
# Ce script configure un serveur vierge de A à Z :
# 1. Mise à jour de l'OS et paquets de base (curl, git, unzip, ufw)
# 2. Installation de PHP 8.2 + extensions obligatoires Laravel 11
# 3. Installation et sécurisation de MySQL + création BDD et utilisateur
# 4. Installation de Nginx, Composer et Node.js 20 LTS (NPM)
# 5. Clonage du projet Git
# 6. Génération et configuration du fichier .env
# 7. Installation des dépendances PHP et Node + build Vite
# 8. Génération de la clé d'application et exécution des migrations BDD
# 9. Configuration du VirtualHost Nginx et des permissions (www-data)
# ==============================================================================

set -e

# Couleurs pour le terminal
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
CYAN='\033[0;36m'
NC='\033[0m'

clear
echo -e "${PURPLE}======================================================================${NC}"
echo -e "${PURPLE}   🚀 INSTALLATION COMPLÈTE SERVEUR & DÉPLOIEMENT PGDE (LARAVEL 11)   ${NC}"
echo -e "${PURPLE}======================================================================${NC}\n"

# Vérification des droits root
if [ "$EUID" -ne 0 ]; then
    echo -e "${RED}❌ Ce script doit être exécuté en tant que root (sudo su ou sudo ./setup-server.sh)${NC}"
    exit 1
fi

# ==============================================================================
# PARAMÈTRES ET CONFIGURATION (AVEC VALEURS PAR DÉFAUT)
# ==============================================================================
echo -e "${CYAN}--- 1. Configuration initiale ---${NC}"

read -p "Nom de domaine ou IP publique du serveur [ex: emplois.sec.gouv.sn ou 127.0.0.1] : " SERVER_DOMAIN
SERVER_DOMAIN=${SERVER_DOMAIN:-"localhost"}

read -p "Dépôt Git du projet [https://github.com/aichou12/emplois.git] : " GIT_REPO
GIT_REPO=${GIT_REPO:-"https://github.com/aichou12/emplois.git"}

read -p "Branche Git [main] : " GIT_BRANCH
GIT_BRANCH=${GIT_BRANCH:-"main"}

read -p "Dossier d'installation [/var/www/emplois] : " APP_DIR
APP_DIR=${APP_DIR:-"/var/www/emplois"}

read -p "Nom de la base de données MySQL [pgdepgde] : " DB_NAME
DB_NAME=${DB_NAME:-"pgdepgde"}

read -p "Utilisateur MySQL [pgde_user] : " DB_USER
DB_USER=${DB_USER:-"pgde_user"}

# Génération aléatoire d'un mot de passe fort si vide
DEFAULT_DB_PASS=$(tr -dc A-Za-z0-9_- </dev/urandom | head -c 20)
read -p "Mot de passe MySQL pour $DB_USER [$DEFAULT_DB_PASS] : " DB_PASS
DB_PASS=${DB_PASS:-"$DEFAULT_DB_PASS"}

echo -e "\n${GREEN}Paramètres enregistrés :${NC}"
echo -e " Domaine/IP   : ${YELLOW}$SERVER_DOMAIN${NC}"
echo -e " Dossier Web  : ${YELLOW}$APP_DIR${NC}"
echo -e " Base MySQL   : ${YELLOW}$DB_NAME${NC}"
echo -e " Utilisateur  : ${YELLOW}$DB_USER${NC}"
echo -e " Mot de passe : ${YELLOW}$DB_PASS${NC}\n"

read -p "Appuyez sur [Entrée] pour lancer l'installation ou Ctrl+C pour annuler..."

# ==============================================================================
# ÉTAPE 1 : MISE À JOUR DU SYSTÈME ET OUTILS ESSENTIELS
# ==============================================================================
echo -e "\n${BLUE}🔄 [Étape 1/9] Mise à jour du système d'exploitation...${NC}"
export DEBIAN_FRONTEND=noninteractive
apt-get update && apt-get upgrade -y
apt-get install -y curl wget git unzip zip software-properties-common lsb-release ca-certificates apt-transport-https ufw

# ==============================================================================
# ÉTAPE 2 : INSTALLATION DE PHP 8.2 ET EXTENSIONS LARAVEL
# ==============================================================================
echo -e "\n${BLUE}🐘 [Étape 2/9] Installation de PHP 8.2 et des extensions requises...${NC}"

# Ajout du dépôt ondrej/php si sur Ubuntu
if [ -f /etc/lsb-release ]; then
    add-apt-repository -y ppa:ondrej/php
    apt-get update
fi

apt-get install -y \
    php8.2 \
    php8.2-fpm \
    php8.2-cli \
    php8.2-mysql \
    php8.2-mbstring \
    php8.2-xml \
    php8.2-curl \
    php8.2-zip \
    php8.2-gd \
    php8.2-intl \
    php8.2-bcmath \
    php8.2-sqlite3

# Optimisations php.ini (FPM & CLI)
for PHP_INI in /etc/php/8.2/fpm/php.ini /etc/php/8.2/cli/php.ini; do
    if [ -f "$PHP_INI" ]; then
        sed -i "s/upload_max_filesize = .*/upload_max_filesize = 16M/" "$PHP_INI"
        sed -i "s/post_max_size = .*/post_max_size = 20M/" "$PHP_INI"
        sed -i "s/memory_limit = .*/memory_limit = 512M/" "$PHP_INI"
        sed -i "s/max_execution_time = .*/max_execution_time = 300/" "$PHP_INI"
    fi
done

systemctl restart php8.2-fpm
systemctl enable php8.2-fpm

# ==============================================================================
# ÉTAPE 3 : INSTALLATION DE COMPOSER ET NODE.JS (V20 LTS)
# ==============================================================================
echo -e "\n${BLUE}📦 [Étape 3/9] Installation de Composer et Node.js (NPM)...${NC}"

# Composer
if ! command -v composer &> /dev/null; then
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi

# Node.js 20.x LTS
if ! command -v node &> /dev/null; then
    curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
    apt-get install -y nodejs
fi

echo -e "PHP Version      : $(php -v | head -n 1)"
echo -e "Composer Version : $(composer --version | head -n 1)"
echo -e "Node Version     : $(node -v)"
echo -e "NPM Version      : $(npm -v)"

# ==============================================================================
# ÉTAPE 4 : INSTALLATION ET CONFIGURATION DE MYSQL
# ==============================================================================
echo -e "\n${BLUE}🗄️  [Étape 4/9] Installation et configuration de MySQL...${NC}"
apt-get install -y mysql-server
systemctl start mysql
systemctl enable mysql

# Création de la base de données et de l'utilisateur
mysql -e "CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -e "CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED WITH mysql_native_password BY '${DB_PASS}';"
mysql -e "ALTER USER '${DB_USER}'@'localhost' IDENTIFIED WITH mysql_native_password BY '${DB_PASS}';"
mysql -e "GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"

echo -e "${GREEN}Base de données '${DB_NAME}' et utilisateur '${DB_USER}' créés avec succès !${NC}"

# ==============================================================================
# ÉTAPE 5 : INSTALLATION DE NGINX
# ==============================================================================
echo -e "\n${BLUE}🌐 [Étape 5/9] Installation de Nginx...${NC}"
apt-get install -y nginx
systemctl start nginx
systemctl enable nginx

# ==============================================================================
# ÉTAPE 6 : CLONAGE DU PROJET PGDE
# ==============================================================================
echo -e "\n${BLUE}📥 [Étape 6/9] Clonage du projet depuis GitHub...${NC}"
mkdir -p /var/www

if [ -d "$APP_DIR" ]; then
    echo -e "${YELLOW}Le dossier $APP_DIR existe déjà. Récupération des dernières modifications...${NC}"
    cd "$APP_DIR"
    git fetch origin "$GIT_BRANCH"
    git reset --hard origin/"$GIT_BRANCH"
else
    git clone -b "$GIT_BRANCH" "$GIT_REPO" "$APP_DIR"
    cd "$APP_DIR"
fi

# ==============================================================================
# ÉTAPE 7 : GÉNÉRATION DU FICHIER .ENV
# ==============================================================================
echo -e "\n${BLUE}⚙️  [Étape 7/9] Configuration du fichier .env de production...${NC}"

cat > "$APP_DIR/.env" <<EOF
APP_NAME="Plateforme de Gestion des Demandes d'Emploi"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_TIMEZONE=Africa/Dakar
APP_URL=http://${SERVER_DOMAIN}

APP_LOCALE=fr
APP_FALLBACK_LOCALE=fr
APP_FAKER_LOCALE=fr_FR

LOG_CHANNEL=daily
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=${DB_NAME}
DB_USERNAME=${DB_USER}
DB_PASSWORD=${DB_PASS}

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false

QUEUE_CONNECTION=database
CACHE_STORE=database

FILESYSTEM_DISK=public

MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="no-reply@${SERVER_DOMAIN}"
MAIL_FROM_NAME="\${APP_NAME}"
EOF

# ==============================================================================
# ÉTAPE 8 : INSTALLATION DÉPENDANCES, BUILD VITE ET MIGRATIONS
# ==============================================================================
echo -e "\n${BLUE}🏗️  [Étape 8/9] Installation des dépendances et initialisation Laravel...${NC}"
cd "$APP_DIR"

# 1. Dépendances PHP
echo -e "${YELLOW}Exécution de Composer install (Production)...${NC}"
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

# 2. Clé d'application
echo -e "${YELLOW}Génération de la clé APP_KEY...${NC}"
php artisan key:generate --force

# 3. Dépendances Node et compilation Vite
echo -e "${YELLOW}Compilation des assets Front-End (Vite/Tailwind)...${NC}"
npm install
npm run build

# 4. Migrations BDD
echo -e "${YELLOW}Exécution des migrations de base de données...${NC}"
php artisan migrate --force

# 5. Lien symbolique du storage
echo -e "${YELLOW}Création du lien de stockage storage:link...${NC}"
php artisan storage:link || true

# 6. Mise en cache des configurations pour les performances
echo -e "${YELLOW}Optimisation et mise en cache Laravel...${NC}"
php artisan optimize:clear
php artisan optimize
php artisan view:cache

# ==============================================================================
# ÉTAPE 9 : CONFIGURATION NGINX & PERMISSIONS DE FICHIERS
# ==============================================================================
echo -e "\n${BLUE}🔒 [Étape 9/9] Configuration du VirtualHost Nginx et des permissions...${NC}"

# Configuration du VirtualHost Nginx
NGINX_CONF="/etc/nginx/sites-available/emplois"

cat > "$NGINX_CONF" <<EOF
server {
    listen 80;
    listen [::]:80;
    server_name ${SERVER_DOMAIN};
    root ${APP_DIR}/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php index.html;
    charset utf-8;

    client_max_body_size 20M;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
        fastcgi_read_timeout 300;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF

# Activation du site Nginx
ln -sf "$NGINX_CONF" /etc/nginx/sites-enabled/emplois
rm -f /etc/nginx/sites-enabled/default 2>/dev/null || true

# Test de la configuration Nginx
nginx -t
systemctl reload nginx

# Configuration des permissions utilisateur www-data
echo -e "${YELLOW}Application des droits d'accès aux fichiers (chown / chmod)...${NC}"
chown -R www-data:www-data "$APP_DIR"
find "$APP_DIR" -type f -exec chmod 644 {} \;
find "$APP_DIR" -type d -exec chmod 755 {} \;
chmod -R 775 "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"
chown -R www-data:www-data "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"

# Assurer que deploy.sh est exécutable
chmod +x "$APP_DIR/deploy.sh" 2>/dev/null || true

# ==============================================================================
# CONFIGURATION DU PARE-FEU (UFW)
# ==============================================================================
if command -v ufw &> /dev/null; then
    ufw allow 'OpenSSH' || true
    ufw allow 'Nginx Full' || true
fi

# ==============================================================================
# RÉCAPITULATIF FINAL
# ==============================================================================
echo -e "\n${GREEN}======================================================================${NC}"
echo -e "${GREEN}🎉 INSTALLATION ET DÉPLOIEMENT TERMINÉS AVEC SUCCÈS !${NC}"
echo -e "${GREEN}======================================================================${NC}"
echo -e "🌐 Site Web accessible sur : ${CYAN}http://${SERVER_DOMAIN}${NC}"
echo -e "📁 Répertoire du projet     : ${CYAN}${APP_DIR}${NC}"
echo -e "🗄️  Base de données MySQL    : ${CYAN}${DB_NAME}${NC}"
echo -e "👤 Utilisateur MySQL        : ${CYAN}${DB_USER}${NC}"
echo -e "🔑 Mot de passe MySQL       : ${CYAN}${DB_PASS}${NC}"
echo -e "📄 Fichier d'environnement  : ${CYAN}${APP_DIR}/.env${NC}"
echo -e "\n${YELLOW}💡 Pour les futures mises à jour rapides, exécutez simplement :${NC}"
echo -e "   cd ${APP_DIR} && ./deploy.sh\n"
