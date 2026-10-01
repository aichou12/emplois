-- ==============================================================================
-- MISE A NIVEAU DU SCHEMA SYMFONY -> LARAVEL 11
-- ==============================================================================

-- 1. Ajout des colonnes Laravel dans userdata et extension des types
ALTER TABLE userdata
  ADD COLUMN nombreanneeexpe LONGTEXT NULL,
  ADD COLUMN posteoccupe LONGTEXT NULL,
  ADD COLUMN employeur LONGTEXT NULL,
  ADD COLUMN diplome_file TEXT NULL,
  ADD COLUMN cv_file TEXT NULL,
  ADD COLUMN photo_profil VARCHAR(255) NULL,
  ADD COLUMN cv_summary TEXT NULL,
  ADD COLUMN country_id INT(11) NULL,
  ADD COLUMN addresse VARCHAR(255) NULL,
  ADD COLUMN created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  ADD COLUMN updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  MODIFY COLUMN diplome LONGTEXT NULL,
  MODIFY COLUMN autresdiplomes LONGTEXT NULL,
  MODIFY COLUMN etablissementdiplome LONGTEXT NULL;

-- 2. Table user_academic
CREATE TABLE IF NOT EXISTS `user_academic` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userdata_id` bigint(20) unsigned NOT NULL,
  `academic_id` bigint(20) unsigned NOT NULL,
  `diplome` varchar(255) NOT NULL,
  `etablissementdiplome` varchar(255) NOT NULL,
  `anneediplome` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Vue liste_utilisateurs
CREATE OR REPLACE VIEW `liste_utilisateurs` AS 
select `id`, `numberid`, `firstname`, `lastname`, `username`, `email`, `date_inscription`, `enabled`, `username_canonical`, `email_canonical`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `recruted` 
from `utilisateur`;

-- 4. Initialisation du suivi des migrations Laravel
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `migrations` (`migration`, `batch`) VALUES
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
