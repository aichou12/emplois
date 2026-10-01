#!/usr/bin/env bash

# ==============================================================================
# SCRIPT DE REPRISE DE DONNÉES MASSIVE (SYMFONY -> LARAVEL 11)
# ==============================================================================
# Ce script importe l'intégralité du dump de production (353 000+ utilisateurs
# et 241 000+ dossiers userdata) et adapte le schéma vers Laravel sans perte.
# ==============================================================================

set -e

GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

DB_NAME="pgdepgde"
DB_USER="pgde_mfpdsi"
DB_PASS="Emploi2026@Password#"
DUMP_DIR="${1:-/root/dump_pgde}"

echo -e "${BLUE}===================================================================${NC}"
echo -e "${BLUE}🚀 DÉBUT DE LA REPRISE DE DONNÉES PGDE - $(date '+%Y-%m-%d %H:%M:%S')${NC}"
echo -e "${BLUE}Dossier source : ${YELLOW}${DUMP_DIR}${NC}"
echo -e "${BLUE}===================================================================${NC}"

if [ ! -d "$DUMP_DIR" ]; then
    echo -e "${RED}❌ Erreur : Dossier '$DUMP_DIR' introuvable.${NC}"
    echo "Usage : ./import_legacy_data.sh [chemin_vers_les_fichiers_sql]"
    exit 1
fi

MYSQL_CMD="mysql -u${DB_USER} -p${DB_PASS} -h127.0.0.1 ${DB_NAME}"

# 1. Importation des 7 tables de référence / nomenclature
echo -e "\n${YELLOW}📚 [1/6] Importation des tables de référence...${NC}"
for TABLE_FILE in pgde_academic.sql pgde_countries.sql pgde_departement.sql pgde_emploi.sql pgde_handicap.sql pgde_region.sql pgde_secteur.sql; do
    if [ -f "${DUMP_DIR}/${TABLE_FILE}" ]; then
        echo -e "  -> Import de ${TABLE_FILE}..."
        $MYSQL_CMD < "${DUMP_DIR}/${TABLE_FILE}"
    fi
done

# 2. Importation des tables techniques fournies (sessions, cache, users)
echo -e "\n${YELLOW}⚙️  [2/6] Importation des tables techniques d'origine...${NC}"
for TECH_FILE in pgde_users.sql pgde_password_reset_tokens.sql pgde_sessions.sql pgde_cache.sql pgde_cache_locks.sql; do
    if [ -f "${DUMP_DIR}/${TECH_FILE}" ]; then
        echo -e "  -> Import de ${TECH_FILE}..."
        $MYSQL_CMD < "${DUMP_DIR}/${TECH_FILE}" || true
    fi
done

# 3. Importation des 353 475 Utilisateurs (Schéma 100% identique)
echo -e "\n${YELLOW}👥 [3/6] Importation de la table 'utilisateur' (353 000+ comptes)...${NC}"
if [ -f "${DUMP_DIR}/pgde_utilisateur.sql" ]; then
    $MYSQL_CMD < "${DUMP_DIR}/pgde_utilisateur.sql"
    echo -e "${GREEN}  ✓ Table utilisateur importée avec succès !${NC}"
fi

# 4. Importation des 241 104 profils Userdata (Ancien schéma 27 colonnes)
echo -e "\n${YELLOW}📄 [4/6] Importation de la table 'userdata' (241 000+ profils)...${NC}"
if [ -f "${DUMP_DIR}/pgde_userdata.sql" ]; then
    $MYSQL_CMD < "${DUMP_DIR}/pgde_userdata.sql"
    echo -e "${GREEN}  ✓ Données brutes userdata importées !${NC}"
fi

# 5. Adaptation du schéma 'userdata' vers Laravel 11 (Ajout des 11 colonnes manquantes)
echo -e "\n${YELLOW}🔧 [5/6] Migration et adaptation de 'userdata' vers Laravel...${NC}"
$MYSQL_CMD -e "
ALTER TABLE userdata
  ADD COLUMN IF NOT EXISTS nombreanneeexpe LONGTEXT NULL,
  ADD COLUMN IF NOT EXISTS posteoccupe LONGTEXT NULL,
  ADD COLUMN IF NOT EXISTS employeur LONGTEXT NULL,
  ADD COLUMN IF NOT EXISTS diplome_file TEXT NULL,
  ADD COLUMN IF NOT EXISTS cv_file TEXT NULL,
  ADD COLUMN IF NOT EXISTS photo_profil VARCHAR(255) NULL,
  ADD COLUMN IF NOT EXISTS cv_summary TEXT NULL,
  ADD COLUMN IF NOT EXISTS country_id INT(11) NULL,
  ADD COLUMN IF NOT EXISTS addresse VARCHAR(255) NULL,
  ADD COLUMN IF NOT EXISTS created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  MODIFY COLUMN diplome LONGTEXT NULL,
  MODIFY COLUMN autresdiplomes LONGTEXT NULL,
  MODIFY COLUMN etablissementdiplome LONGTEXT NULL;
"
echo -e "${GREEN}  ✓ Schéma userdata mis à niveau avec succès !${NC}"

# Création de la table user_academic
$MYSQL_CMD -e "
CREATE TABLE IF NOT EXISTS \`user_academic\` (
  \`id\` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  \`userdata_id\` bigint(20) unsigned NOT NULL,
  \`academic_id\` bigint(20) unsigned NOT NULL,
  \`diplome\` varchar(255) NOT NULL,
  \`etablissementdiplome\` varchar(255) NOT NULL,
  \`anneediplome\` int(11) DEFAULT NULL,
  \`created_at\` timestamp NULL DEFAULT NULL,
  \`updated_at\` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (\`id\`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
"
echo -e "${GREEN}  ✓ Table user_academic configurée !${NC}"

# Création de la vue liste_utilisateurs
$MYSQL_CMD -e "
CREATE OR REPLACE VIEW \`liste_utilisateurs\` AS 
select \`id\`, \`numberid\`,\`firstname\`, \`lastname\`, \`username\`, \`email\`, \`date_inscription\`, \`enabled\`, \`username_canonical\`, \`email_canonical\`, \`last_login\`, \`confirmation_token\`, \`password_requested_at\`, \`roles\`, \`recruted\` 
from \`utilisateur\`;
"
echo -e "${GREEN}  ✓ Vue liste_utilisateurs créée !${NC}"

# 6. Exécution des migrations techniques Laravel
echo -e "\n${YELLOW}⚡ [6/6] Exécution des migrations système Laravel...${NC}"
if [ -f "/var/www/emplois/artisan" ]; then
    cd /var/www/emplois

    # Enregistrement des tables déjà importées pour éviter tout conflit de création
    $MYSQL_CMD -e "
    CREATE TABLE IF NOT EXISTS \`migrations\` (
      \`id\` int(10) unsigned NOT NULL AUTO_INCREMENT,
      \`migration\` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
      \`batch\` int(11) NOT NULL,
      PRIMARY KEY (\`id\`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

    INSERT IGNORE INTO \`migrations\` (\`migration\`, \`batch\`) VALUES
      ('0001_01_01_000000_create_users_table', 1),
      ('0001_01_01_000001_create_cache_table', 1),
      ('2025_01_28_145414_create_countries_table', 1),
      ('2025_01_28_194756_create_secteurs_table', 1),
      ('2025_01_28_194802_create_emplois_table', 1),
      ('2025_02_16_000000_create_userdata_table', 1),
      ('2025_02_17_074057_add_files_to_userdata_table', 1),
      ('2025_02_18_075305_add_photo_to_userdata_table', 1),
      ('2025_03_04_084751_create_user_academic_table', 1),
      ('2026_09_21_110107_change_autresdiplomes_column_type_in_userdata_table', 1);
    "

    php artisan migrate --force
    php artisan optimize:clear
fi

echo -e "\n${GREEN}===================================================================${NC}"
echo -e "${GREEN}🎉 REPRISE DE DONNÉES TERMINÉE AVEC SUCCÈS ! - $(date '+%Y-%m-%d %H:%M:%S')${NC}"
echo -e "${GREEN}===================================================================${NC}"
