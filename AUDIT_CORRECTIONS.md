# 🛡️ Rapport d'Audit & Journal des Corrections Backend

*Date d'initialisation : 08 Septembre 2026*  
*Projet : Plateforme Emplois*

---

## 📋 1. Recensement des Failles & Problèmes Identifiés

| ID | Catégorie | Description / Problème | Gravité | Statut |
| :--- | :--- | :--- | :--- | :--- |
| **BUG-01** | **Affichage / Données** | L'expérience professionnelle s'affiche en JSON brut dans le formulaire de modification du profil (`edit.blade.php`) et provoque une perte/corruption des données lors de la soumission. | Moyenne | ✅ Corrigé |
| **BUG-04** | **Affichage / Données** | Seule la 1ère formation était affichée et éditable dans `edit.blade.php` et `resumer.blade.php`, ignorant les formations multiples stockées dans `autresdiplomes`. | Moyenne | ✅ Corrigé |
| **BUG-05** | **Fonctionnalité / Fichiers** | Le changement de photo de profil écrasait ou ne persistait pas la nouvelle image et ne se déclenchait pas automatiquement. | Moyenne | ✅ Corrigé |
| **SEC-01** | **Contrôle d'accès (Privilege Escalation)** | Possibilité pour un utilisateur de s'inscrire en tant qu'administrateur en passant le paramètre `is_admin=1` dans le formulaire d'inscription (`AuthController::register`). | 🔴 Critique | ✅ Corrigé |
| **SEC-02** | **Contrôle d'accès (IDOR)** | Absence de vérification de propriété (`auth()->id() === $userdata->utilisateur_id`) sur les routes d'édition, mise à jour, suppression de fichiers (`UserdataController`). | 🔴 Critique | ✅ Corrigé |
| **SEC-03** | **Authentification / Sécurité URL** | Liens de vérification d'email sans middleware `signed` ou vérification de signature cryptographique dans `VerificationController`. | 🟠 Haute | ✅ Corrigé |
| **SEC-04** | **Contrôle d'accès / Middleware** | Plusieurs routes sensibles de gestion de profil et d'administration ne sont pas protégées par les middlewares `auth` ou `admin`. | 🟠 Haute | ✅ Corrigé |
| **SEC-05** | **Sécurité PHP (Désérialisation)** | Utilisation de `unserialize()` sur le champ `roles` de la table `utilisateur` au lieu de formats sécurisés (JSON ou relations Eloquent). | 🟡 Moyenne | ⏳ À traiter |
| **BUG-02** | **Authentification** | Connexion autorisée même si le compte n'a pas été validé par email (`enabled == 0`). | 🟡 Moyenne | ⏳ À traiter |
| **BUG-03** | **Architecture / Routing** | Présence de routes déclarées en double et logique métier dans des closures dans `routes/web.php`. | 🟢 Faible | ⏳ À traiter |

---

## 🕒 2. Journal des Corrections (Historique Horodaté)

### [08/09/2026 - 17:05] Initialisation du rapport
- Recensement exhaustif des anomalies et vulnérabilités backend détectées.

### [08/09/2026 - 17:08] Résolution de BUG-01 (Expériences professionnelles / JSON brut)
- **Fichiers modifiés** :
  - [`app/Http/Controllers/UserdataController.php`](file:///C:/Mes%20projets/emplois/app/Http/Controllers/UserdataController.php) : Décodage du JSON des expériences stockées dans `edit()` pour passage sous forme de tableau PHP à la vue, et ajout d'un contrôle d'autorisation d'accès (propriétaire ou admin).
  - [`resources/views/userdata/edit.blade.php`](file:///C:/Mes%20projets/emplois/resources/views/userdata/edit.blade.php) :
    - Remplacement de l'input texte statique par une liste dynamique de formulaires d'expériences pré-remplis (`description`, `years`, `poste`, `employeur`).
    - Correction du champ `hasExperience` et du mapping de structure `experiences[index][...]` correspondant à la validation de `UserdataController::update`.
    - Refonte du script JavaScript d'ajout/suppression dynamique d'expériences pour réindexer proprement les champs.
  - [`resources/views/userdata/resumer.blade.php`](file:///C:/Mes%20projets/emplois/resources/views/userdata/resumer.blade.php) : Décodage et rendu propre des cartes d'expérience professionnelle sans afficher le texte JSON brut.

### [08/09/2026 - 17:23] Résolution de BUG-04 (Formations multiples tronquées à la première)
- **Fichiers modifiés** :
  - [`app/Http/Controllers/UserdataController.php`](file:///C:/Mes%20projets/emplois/app/Http/Controllers/UserdataController.php) : Décodage de la colonne `autresdiplomes` dans la méthode `edit()` et transmission du tableau complet `$formations` à la vue.
  - [`resources/views/userdata/edit.blade.php`](file:///C:/Mes%20projets/emplois/resources/views/userdata/edit.blade.php) : Remplacement du formulaire statique mono-formation par un module dynamique complet de gestion des formations (`formations[i][academic_id]`, `diplome`, `anneediplome`, `specialite`, `etablissementdiplome`) avec bouton d'ajout/suppression et masquage automatique pour "Sans diplôme".
  - [`resources/views/userdata/resumer.blade.php`](file:///C:/Mes%20projets/emplois/resources/views/userdata/resumer.blade.php) : Rendu dynamique de toutes les formations enregistrées dans `autresdiplomes` avec mapping des niveaux d'études.

### [08/09/2026 - 17:56] Résolution de l'affichage sur la page de résumé / profil (`summary.blade.php` & `resume.blade.php`)
- **Fichiers modifiés** :
  - [`resources/views/userdata/summary.blade.php`](file:///C:/Mes%20projets/emplois/resources/views/userdata/summary.blade.php) : La page récapitulative après enregistrement (`/userdata/summary/{id}`) n'affichait que la première formation et tronquait les détails des expériences supplémentaires. Intégration du décodage JSON complet pour afficher toutes les formations (`autresdiplomes`) et toutes les expériences (`experiences`) sous forme de fiches détaillées.
  - [`resources/views/userdata/resume.blade.php`](file:///C:/Mes%20projets/emplois/resources/views/userdata/resume.blade.php) : Même mise à niveau sur la vue CV globale.

### [08/09/2026 - 18:09] Correction de la structure HTML du formulaire multi-étapes (`edit.blade.php`)
- **Problème** : La balise `<form>` s'ouvrait à l'intérieur du `<div id="step-1">` et se fermait dans l'étape 4, provoquant la fermeture prématurée du formulaire par le navigateur et empêchant la transmission des étapes 2 (formations), 3 (expériences) et 4 (emplois) lors de la soumission.
- **Correction** :
  - [`resources/views/userdata/edit.blade.php`](file:///C:/Mes%20projets/emplois/resources/views/userdata/edit.blade.php) : Déplacement de la balise ouvrante `<form>` avant le `<div id="step-1">` et de la balise fermante `</form>` après la fin du `<div id="step-4">` pour englober correctement l'intégralité des 4 étapes du wizard.

### [08/09/2026 - 18:16] Résolution de BUG-05 (Changement et persistance de la photo de profil)
- **Fichiers modifiés** :
  - [`app/Http/Controllers/UserdataController.php`](file:///C:/Mes%20projets/emplois/app/Http/Controllers/UserdataController.php) :
    - Dans `update()` : `unset($validated['photo_profil'])` lorsqu'aucune nouvelle photo n'est fournie afin d'éviter d'écraser la photo existante avec `NULL`.
    - Dans `updatePhotoProfil()` : Harmonisation du stockage vers `uploads/photos/` (suppression de l'ancienne photo sur disque pour éviter les fichiers orphelins) et ajout d'un contrôle d'accès IDOR.
  - [`resources/views/userdata/summary.blade.php`](file:///C:/Mes%20projets/emplois/resources/views/userdata/summary.blade.php) : Déclenchement automatique de l'upload AJAX dès la sélection du fichier et rafraîchissement immédiat de l'image de profil avec anti-cache.
  - [`resources/views/userdata/edit.blade.php`](file:///C:/Mes%20projets/emplois/resources/views/userdata/edit.blade.php) : Balise d'aperçu d'image persistante et sécurisée.

### [08/09/2026 - 18:29] Résolution de SEC-01 (Élévation de privilèges lors de l'inscription)
- **Problème** : Le contrôleur d'inscription acceptait un paramètre `is_admin` depuis la requête utilisateur, permettant à n'importe quel attaquant d'obtenir le rôle d'administrateur (`a:1:{i:0;s:5:"admin";}`).
- **Correction** :
  - [`app/Http/Controllers/AuthController.php`](file:///C:/Mes%20projets/emplois/app/Http/Controllers/AuthController.php) : Suppression totale de la condition `if ($request->has('is_admin'))` et assignation stricte et immuable du rôle utilisateur standard (`a:0:{}`) lors de l'inscription. Suppression également de la requête SQL redondante sur `numberid`.

### [08/09/2026 - 18:43] Résolution de SEC-02 (Vulnérabilités IDOR / Contrôle d'accès objet direct)
- **Problème** : Des utilisateurs authentifiés pouvaient modifier, consulter le récapitulatif ou supprimer les fichiers/CV d'autres candidats en envoyant un `userdata_id` ou `id` arbitraire.
- **Correction** :
  - [`app/Http/Controllers/UserdataController.php`](file:///C:/Mes%20projets/emplois/app/Http/Controllers/UserdataController.php) : Ajout systématique du contrôle de propriété (`$userdata->utilisateur_id === auth()->id() || auth()->user()->hasRole('admin')`) sur toutes les méthodes restantes :
    - `deleteFile()` : vérification avant suppression d'un diplôme sur disque et en BDD.
    - `deleteCvFile()` : vérification avant suppression d'un CV sur disque et en BDD.
    - `summary()` : restriction de l'accès à la fiche récapitulative au propriétaire et aux administrateurs.
    - `resume()` : restriction de la consultation du CV complet au propriétaire et aux administrateurs.

### [08/09/2026 - 18:46] Résolution de SEC-03 (Sécurisation cryptographique des URLs de vérification d'email)
- **Problème** : La route `/email/verify/{id}/{hash}` n'appliquait pas le middleware `signed` et ne validait pas la signature temporelle/cryptographique de l'URL, rendant possible la falsification d'activation si un hash sha1 était deviné ou calculé. De plus, le token expirait après seulement 5 minutes dans la notification.
- **Correction** :
  - [`routes/web.php`](file:///C:/Mes%20projets/emplois/routes/web.php) : Ajout du middleware standard `signed` sur la route `verification.verify`.
  - [`app/Http/Controllers/VerificationController.php`](file:///C:/Mes%20projets/emplois/app/Http/Controllers/VerificationController.php) : Ajout d'une vérification explicite `$request->hasValidSignature()` avant de charger l'utilisateur et d'activer le compte.
  - [`app/Notifications/CustomVerifyEmail.php`](file:///C:/Mes%20projets/emplois/app/Notifications/CustomVerifyEmail.php) : Extension de la durée de validité du lien temporaire signé à 60 minutes (`now()->addMinutes(60)`) pour garantir une utilisation confortable par les utilisateurs tout en restant protégé contre le rejeu ou la falsification.

### [08/09/2026 - 18:50] Résolution de SEC-04 (Contrôle d'accès et cloisonnement des middlewares)
- **Problème** : Plusieurs dizaines de routes d'administration (`/admin/users`, suppression, modification, filtres de listes) et de formulaires de candidats étaient déclarées à la racine sans protection `auth` ou `role:admin`.
- **Correction** :
  - [`bootstrap/app.php`](file:///C:/Mes%20projets/emplois/bootstrap/app.php) : Enregistrement officiel des alias de middlewares `'role' => RoleMiddleware::class` et `'enabled' => CheckAccountEnabled::class`.
  - [`routes/web.php`](file:///C:/Mes%20projets/emplois/routes/web.php) : Refonte et réorganisation complète par groupes étanches :
    - Groupe public pour les invités (`middleware('guest')`).
    - Groupe candidat authentifié (`middleware('auth')`).
    - Groupe administration sécurisé (`middleware(['auth', 'role:admin'])->prefix('admin')`).
    - Route de déconnexion sécurisée (`POST /logout`).

---

