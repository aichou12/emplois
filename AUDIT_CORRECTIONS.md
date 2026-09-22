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
| **BUG-06** | **Base de données / Modèle** | Erreur SQL `1406 Data too long for column 'autresdiplomes'` lors de l'enregistrement de plusieurs diplômes/formations (`VARCHAR(255)` trop court pour le JSON). | 🟠 Haute | ✅ Corrigé |
| **BUG-07** | **Authentification / Déconnexion** | Le clic sur le bouton « Déconnexion » ne déconnectait pas l'utilisateur et le redirigeait en boucle sur la même page (liens pointant vers `/login` sous middleware `guest`). | 🟠 Haute | ✅ Corrigé |
| **BUG-08** | **Affichage / Assets** | Image d'illustration et logos brisés sur la page de connexion administrateur (`admin-login.blade.php`) suite à un nom de fichier erroné (`admin1.jpg` vs `admin.jpg`) et des chemins relatifs. | 🟢 Faible | ✅ Corrigé |
| **BUG-09** | **Navigation / Routing Admin** | Erreurs 404 (Not Found) sur les cartes statistiques et liens de retour du dashboard admin causées par des URLs écrites en dur sans le préfixe `/admin/` au lieu d'utiliser les routes nommées (`route('...')`). | 🟠 Haute | ✅ Corrigé |
| **BUG-10** | **Fichiers / Téléversement CV** | Fichiers CV joints non visibles dans les récapitulatifs (`summary.blade.php`, `resume.blade.php`) et limite de validation bloquante à 2 Mo (`max:2048`) en conflit avec l'indication utilisateur (8 Mo). | 🟠 Haute | ✅ Corrigé |
| **SEC-01** | **Contrôle d'accès (Privilege Escalation)** | Possibilité pour un utilisateur de s'inscrire en tant qu'administrateur en passant le paramètre `is_admin=1` dans le formulaire d'inscription (`AuthController::register`). | 🔴 Critique | ✅ Corrigé |
| **SEC-02** | **Contrôle d'accès (IDOR)** | Absence de vérification de propriété (`auth()->id() === $userdata->utilisateur_id`) sur les routes d'édition, mise à jour, suppression de fichiers (`UserdataController`). | 🔴 Critique | ✅ Corrigé |
| **SEC-03** | **Authentification / Sécurité URL** | Liens de vérification d'email sans middleware `signed` ou vérification de signature cryptographique dans `VerificationController`. | 🟠 Haute | ✅ Corrigé |
| **SEC-04** | **Contrôle d'accès / Middleware** | Plusieurs routes sensibles de gestion de profil et d'administration ne sont pas protégées par les middlewares `auth` ou `admin`. | 🟠 Haute | ✅ Corrigé |
| **BUG-12** | **Navigation / Routing** | Erreur 404 (Not Found) lors du clic sur le bouton « Retour » depuis la page CV (`/userdata/{id}/resume`) due à un lien statique `/liste_demandeur` (route admin préfixée) inaccessible et inapproprié pour les candidats normaux. | 🟠 Haute | ✅ Corrigé |
| **SEC-07** | **Sécurité / Rate Limiting (Brute Force)** | Absence de limitation du débit (Rate Limiting) sur les endpoints sensibles (`POST /login`, `POST /admin/login`, `POST /register`, `POST /forgot-password`, `POST /change-password`), exposant la plateforme aux attaques par force brute ou saturation. | 🟠 Haute | ✅ Corrigé |
| **SEC-05** | **Sécurité PHP (Désérialisation)** | Utilisation de `unserialize()` sur le champ `roles` de la table `utilisateur` au lieu de formats sécurisés (JSON ou relations Eloquent). | 🟡 Moyenne | ⏳ À traiter |
| **SEC-06** | **Contrôle d'accès / Modèle erroné** | La route AJAX `/check-email` utilisait le modèle `User` (table `users`, vide) au lieu de `Utilisateur` (table `utilisateur`). La vérification de doublons d'email lors de l'inscription était donc toujours `false`, permettant un feedback AJAX incorrect (la validation serveur bloquait quand même, mais le retour visuel était faux). | 🟡 Moyenne | ✅ Corrigé |
| **BUG-02** | **Authentification** | Connexion autorisée même si le compte n'a pas été validé par email (`enabled == 0`). | 🟡 Moyenne | ⏳ À traiter |
| **BUG-03** | **Architecture / Routing** | Présence de routes déclarées en double et logique métier dans des closures dans `routes/web.php`. | 🟢 Faible | ⏳ À traiter |
| **BUG-11** | **Séparation des rôles** | Un utilisateur ayant le rôle `admin` peut se connecter via `/login` (formulaire candidat) sans aucun blocage. La route `/home` le redirige ensuite vers l'espace admin, créant une confusion et un contournement potentiel du portail `/admin/login`. | 🟠 Haute | ⏳ À traiter |

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

### [21/09/2026 - 13:02] Résolution de BUG-06 (Erreur SQL 1406 Data too long pour `autresdiplomes`)
- **Problème** : La colonne `autresdiplomes` de la table `userdata` était définie en `VARCHAR(255)` dans la base MySQL active. Lors de l'enregistrement de plusieurs diplômes/formations au format JSON (comme `[{"academic_id":"7","diplome":"BACCALAUREAT",...}, ...]`), la chaîne dépassait la limite des 255 caractères et déclenchait l'exception `SQLSTATE[22001]: String data, right truncated: 1406 Data too long for column 'autresdiplomes'`.
- **Correction** :
  - Modification de la structure de la table MySQL via `ALTER TABLE userdata MODIFY autresdiplomes LONGTEXT NULL;` (identique au champ `experiences` qui est en `LONGTEXT`).
  - [`database/migrations/2026_09_21_110107_change_autresdiplomes_column_type_in_userdata_table.php`](file:///C:/Mes%20projets/emplois/database/migrations/2026_09_21_110107_change_autresdiplomes_column_type_in_userdata_table.php) : Création de la migration de schéma Laravel correspondante pour pérenniser l'évolution de la colonne en `longText`.

### [21/09/2026 - 13:21] Résolution de BUG-07 (Déconnexion inopérante et redirection en boucle)
- **Problème** : Lorsque l'utilisateur ou l'administrateur cliquait sur le bouton « Déconnexion », le lien hypertexte redirigeait directement en requête `GET` vers `/login` ou `/admin/login`. Comme l'utilisateur était encore authentifié et que la route `/login` était sous le middleware `guest`, Laravel le redirigeait immédiatement vers sa page d'origine sans jamais détruire sa session (l'action de déconnexion `Auth::logout()` n'était jamais appelée).
- **Correction** :
  - [`app/Http/Controllers/AuthController.php`](file:///C:/Mes%20projets/emplois/app/Http/Controllers/AuthController.php) : Ajout de la méthode contrôleur dédiée `logout(Request $request)` assurant l'invalidation complète de la session (`Auth::logout()`, `$request->session()->invalidate()`, `$request->session()->regenerateToken()`) et redirection vers la page de connexion.
  - [`routes/web.php`](file:///C:/Mes%20projets/emplois/routes/web.php) : Mise à jour de la route `Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout')` pour gérer à la fois les liens GET et les formulaires POST.
  - Mise à jour de toutes les vues candidat (`summary.blade.php`, `edit.blade.php`, `create.blade.php`, `resumer.blade.php`) et des 23 vues administrateur (`resources/views/admin/*.blade.php`) pour pointer le bouton de déconnexion vers `{{ route('logout') }}`.

### [21/09/2026 - 13:33] Résolution de BUG-08 (Image d'illustration et assets brisés sur `admin-login.blade.php`)
- **Problème** : L'illustration sur la page de connexion administrateur (`/admin/login`) ne s'affichait pas (seul le texte alternatif `Illustration` apparaissait) en raison d'un nom de fichier erroné (`admin1.jpg` au lieu de `admin.jpg`) et de l'usage de chemins relatifs (`../images/...`) incompatibles avec le routing imbriqué de Laravel.
- **Correction** :
  - [`resources/views/auth/admin-login.blade.php`](file:///C:/Mes%20projets/emplois/resources/views/auth/admin-login.blade.php) :
    - Remplacement de `../images/admin1.jpg` par `{{ asset('images/admin.jpg') }}`.
    - Sécurisation du favicon et des logos du header avec le helper Laravel `{{ asset('images/...') }}` (`dss.png` et `mfp.png`).

### [21/09/2026 - 14:57] Résolution de BUG-09 (Erreurs 404 sur les liens et listes du tableau de bord Admin)
- **Problème** : Lors du clic sur les cartes statistiques du dashboard admin (`/admin/users`) ou sur les boutons de retour « Retourner à la liste », des erreurs 404 (Page Not Found) se produisaient. Les balises `<a>` contenaient des URLs relatives absolues sans le préfixe `/admin/` (ex: `href="/liste_demandeur"`, `href="/sans_diplome"`, `href="/nombre_inscrit"`), alors que toutes les routes d'administration sont regroupées sous le préfixe `/admin/` (`/admin/liste_demandeur`, etc.).
- **Correction** :
  - [`resources/views/admin/index.blade.php`](file:///C:/Mes%20projets/emplois/resources/views/admin/index.blade.php) : Remplacement de tous les liens statiques des cartes thématiques par les routes nommées Laravel : `{{ route('liste.utilisateurs') }}`, `{{ route('liste.inscrit') }}`, `{{ route('liste.complet') }}`, `{{ route('liste.pascomplet') }}`, `{{ route('liste.sansdiplome') }}`, `{{ route('liste.avecdiplome') }}`, `{{ route('liste.masculin') }}`, `{{ route('liste.feminin') }}`.
  - Correction des boutons de retour et des titres sur l'ensemble des 10 vues d'édition et de listes d'administration (`resources/views/admin/*.blade.php`).

### [21/09/2026 - 15:07] Résolution de BUG-10 (Prise en charge et affichage des fichiers CV joints)
- **Problème** :
  1. Les fichiers CV téléversés lors de la création ou modification du profil n'étaient jamais affichés sur la fiche récapitulative (`summary.blade.php`) ni sur la vue CV globale (`resume.blade.php`).
  2. La validation Laravel limitait la taille des fichiers à 2 Mo (`max:2048`), alors que les libellés indiquaient `8 Mo max`, entraînant le rejet silencieux des fichiers de taille intermédiaire.
  3. Dans `edit.blade.php`, la liste des CV existants utilisait le même identifiant DOM `id="file_list"` que les diplômes.
- **Correction** :
  - [`app/Http/Controllers/UserdataController.php`](file:///C:/Mes%20projets/emplois/app/Http/Controllers/UserdataController.php) : Augmentation de la limite de validation à 8 Mo (`max:8192`) pour `cv_file`, `diplome_file` et `photo_profil` dans les méthodes `store()` et `update()`.
  - [`resources/views/userdata/summary.blade.php`](file:///C:/Mes%20projets/emplois/resources/views/userdata/summary.blade.php) : Ajout d'une section de téléchargement dynamique et sécurisée pour les fichiers CV joints avec icône et ouverture dans un nouvel onglet.
  - [`resources/views/userdata/resume.blade.php`](file:///C:/Mes%20projets/emplois/resources/views/userdata/resume.blade.php) : Intégration identique de la liste des CV attachés.
  - [`resources/views/userdata/edit.blade.php`](file:///C:/Mes%20projets/emplois/resources/views/userdata/edit.blade.php) : Renommage de l'élément DOM en `cv_existing_list` avec décodage défensif (gérant chaînes et tableaux).

### [22/09/2026 - 12:16] Résolution de BUG-12 (Erreur 404 sur le bouton Retour de la vue CV globale)
- **Problème** :
  - Sur la page de prévisualisation du CV (`/userdata/{id}/resume`), le bouton « Retour à la liste des utilisateurs » contenait un lien en dur `href="/liste_demandeur"`.
  - Cette URL renvoyait une erreur `404 Not Found` car la route correspondante est préfixée sous `/admin/liste_demandeur`.
  - De plus, pour un candidat ordinaire consultant son propre CV, renvoyer vers la liste admin de tous les utilisateurs n'avait pas de sens (et déclencherait un 403 / 404).
- **Correction** :
  - [`resources/views/userdata/resume.blade.php`](file:///C:/Mes%20projets/emplois/resources/views/userdata/resume.blade.php) : Conditionnement dynamique du bouton de retour selon le rôle de l'utilisateur :
    - **Si administrateur** : Redirection vers la liste des utilisateurs via la route nommée `{{ route('liste.utilisateurs') }}` (`/admin/liste_demandeur`).
    - **Si candidat / utilisateur ordinaire** : Redirection vers son récapitulatif de profil via `{{ route('userdata.summary', $utilisateur->userdata->id) }}` (« Retour à mon profil »).

### [22/09/2026 - 12:26] Résolution de SEC-07 (Protection contre les attaques par force brute via Rate Limiting)
- **Problème** : Les formulaires de connexion, d'inscription, de réinitialisation et de changement de mot de passe n'avaient aucun contrôle de cadence, permettant à un attaquant de tester des mots de passe en boucle ou de saturer l'envoi d'emails.
- **Correction** :
  - [`app/Providers/AppServiceProvider.php`](file:///C:/Mes%20projets/emplois/app/Providers/AppServiceProvider.php) : Configuration de RateLimiters personnalisés :
    - Limiteur `login` : 5 tentatives max par minute (par combinaison identifiant + IP).
    - Limiteur `password-reset` : 3 requêtes max par minute (par email + IP).
  - [`routes/web.php`](file:///C:/Mes%20projets/emplois/routes/web.php) : Application des middlewares de limitation de débit :
    - `POST /login` et `POST /admin/login` : `middleware('throttle:login')`
    - `POST /register` : `middleware('throttle:5,1')`
    - `POST /forgot-password` : `middleware('throttle:password-reset')`
    - `POST /reset-password` : `middleware('throttle:5,1')`
    - `POST /change-password` et `POST /auth/change-password` : `middleware('throttle:6,1')`
    - `POST /email/verification-notification` : `middleware('throttle:6,1')`

---



