#!/usr/bin/env bash

# ==============================================================================
# Script de Déploiement Automatisé - Plateforme PGDE (Laravel 11)
# ==============================================================================
# Ce script permet de mettre à jour rapidement et proprement le projet sur le
# serveur de production sans interruption prolongée de service.
#
# Utilisation :
#   chmod +x deploy.sh
#   ./deploy.sh [nom_de_branche]  (par défaut : main)
# ==============================================================================

set -e # Arrêter l'exécution en cas d'erreur bloquante

# Définition des couleurs pour l'affichage
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # Pas de couleur

# Branche par défaut
BRANCH="${1:-main}"

echo -e "${BLUE}=====================================================${NC}"
echo -e "${BLUE}🚀 DÉBUT DU DÉPLOIEMENT PGDE - $(date '+%Y-%m-%d %H:%M:%S')${NC}"
echo -e "${BLUE}Branche cible : ${YELLOW}${BRANCH}${NC}"
echo -e "${BLUE}=====================================================${NC}"

# 1. Vérification que l'on se trouve bien dans le répertoire Laravel
if [ ! -f "artisan" ]; then
    echo -e "${RED}❌ Erreur : Le fichier 'artisan' est introuvable. Exécutez ce script depuis la racine du projet Laravel.${NC}"
    exit 1
fi

# 2. Activation du mode maintenance (avec code secret de contournement facultatif)
echo -e "\n${YELLOW}🔒 [1/8] Passage en mode maintenance...${NC}"
php artisan down --render="errors::503" || true

# 3. Récupération des dernières modifications Git
echo -e "\n${YELLOW}📥 [2/8] Récupération du code distant (${BRANCH})...${NC}"
git fetch origin ${BRANCH}
git reset --hard origin/${BRANCH}

# 4. Installation / Mise à jour des dépendances Composer (Optimisé production)
echo -e "\n${YELLOW}📦 [3/8] Installation des dépendances Composer (PHP)...${NC}"
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

# 5. Compilation des assets Front-End (Vite / Tailwind)
echo -e "\n${YELLOW}🎨 [4/8] Compilation des assets Front-End (Vite)...${NC}"
if command -v npm &> /dev/null; then
    npm install --no-audit --prefer-offline || npm install
    npm run build
else
    echo -e "${YELLOW}⚠️ NPM n'est pas détecté. Ignoré (si les assets sont déjà compilés).${NC}"
fi

# 6. Exécution des migrations de base de données
echo -e "\n${YELLOW}🗄️  [5/8] Application des migrations BDD...${NC}"
php artisan migrate --force

# 7. Création du lien symbolique du storage si nécessaire
echo -e "\n${YELLOW}🔗 [6/8] Vérification du lien de stockage (storage:link)...${NC}"
php artisan storage:link || true

# 8. Nettoyage et mise en cache des configurations (Optimisations Laravel)
echo -e "\n${YELLOW}⚡ [7/8] Mise en cache des configurations et routes...${NC}"
php artisan optimize:clear
php artisan optimize
php artisan view:cache
php artisan event:cache 2>/dev/null || true

# Redémarrer les workers de queue si configurés
php artisan queue:restart || true

# 9. Permissions des dossiers critiques
echo -e "\n${YELLOW}🔑 [8/8] Ajustement des permissions (storage & cache)...${NC}"
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
chown -R www-data:www-data storage bootstrap/cache public/build 2>/dev/null || true

# 10. Désactivation du mode maintenance
echo -e "\n${GREEN}🔓 Réactivation du site...${NC}"
php artisan up

echo -e "\n${GREEN}=====================================================${NC}"
echo -e "${GREEN}✅ DÉPLOIEMENT TERMINÉ AVEC SUCCÈS ! - $(date '+%Y-%m-%d %H:%M:%S')${NC}"
echo -e "${GREEN}=====================================================${NC}"
