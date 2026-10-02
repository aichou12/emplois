# Registre des audits et scans de sécurité

Ce document suit les revues et scans de sécurité réalisés sur la plateforme, leurs résultats et les corrections associées. Il sert de journal de suivi : un point noté ici n’est considéré comme corrigé qu’après vérification.

## État des scans

| Date | Type de revue / scan | Périmètre | État | Résultat |
|---|---|---|---|---|
| 2026-10-01 | Revue statique initiale | Routes, authentification, rôles, téléversements et configuration | Réalisée, première passe | Plusieurs points à confirmer et corriger, détaillés ci-dessous. Ce n’est pas un test d’intrusion. |
| 2026-10-01 | Revue statique de la connexion | Connexion web, admin et API mobile; limitation des tentatives, mots de passe, sessions et jetons | Réalisée, lecture seule | Absence de limitation visible sur la connexion API, limite web contournable par rotation d’identifiants/IP, jetons Sanctum sans expiration configurée et autres points à confirmer. Aucun essai réel de connexion effectué. |
| 2026-10-01 | Revue des ports et de l’accès admin | Écoutes TCP locales, routes admin, scripts de déploiement et configuration Nginx/UFW | Réalisée, lecture seule | Ports 8000 (PHP) et 3306 (MySQL) à l’écoute sur toutes les interfaces IPv4 locales; exposition réseau effective non confirmée. Risque critique potentiel de téléversement de PHP exécutable dans `public/`, plus HTTPS, pare-feu et accès de maintenance à sécuriser. |
| 2026-10-01 | Revue ciblée des attaques contre l’administration | Autorisations admin, blocage IP, journalisation des connexions et sorties HTML | Réalisée, lecture seule | Les routes admin exigent authentification et rôle admin; pas d’attribution de rôle par inscription observée. Le blocage IP ignore volontairement `/admin`; aucun second facteur n’a été trouvé dans le code examiné. Les échecs de connexion sont maintenant journalisés (mise en place du 2026-10-01). |
| À planifier | Dépendances PHP et JavaScript | `composer.lock`, `package-lock.json` | À lancer | Non évalué |
| À planifier | Contrôle d’accès et routes | Routes web/API, accès aux dossiers, fonctions d’administration | À approfondir | Non évalué |
| À planifier | Téléversement et exposition des documents | CV, diplômes, photos, accès direct et règles serveur | À approfondir | Non évalué |
| À planifier | Configuration de production | Variables d’environnement, mode debug, HTTPS, cookies, serveur web | À lancer sur l’environnement de déploiement | Non évalué |
| À planifier | Scan dynamique sur environnement de recette | Parcours web et API, sans données réelles | À planifier | Non évalué |

## Constats de la revue statique initiale

Les constats ci-dessous sont des pistes de risque observées dans le code. Leur impact réel dépend notamment de la configuration du serveur et doit être confirmé pendant les vérifications dédiées.

### Priorité haute — suppression de fichier via l’API

- **Observation :** la suppression de CV reçoit un chemin `file_path` et le transforme en chemin disque sans vérifier qu’il appartient au compte connecté ni qu’il est limité au répertoire de CV.
- **Zone concernée :** `app/Http/Controllers/Api/DocumentApiController.php`, méthode `deleteCv` ; route `DELETE /api/v1/candidat/cv` dans `routes/api.php`.
- **Risque :** suppression d’autres fichiers accessibles au processus PHP si le chemin fourni sort du répertoire attendu.
- **Correction à suivre :** n’accepter qu’un identifiant ou un chemin relatif appartenant à la liste des fichiers du demandeur, canonicaliser le chemin et imposer un répertoire racine autorisé avant toute suppression.
- **État :** à corriger et vérifier.

### Priorité haute — documents personnels servis depuis `public/`

- **Observation :** des CV et justificatifs sont enregistrés sous `public/uploads`. Les URLs ainsi créées peuvent être consultées sans passer par une autorisation applicative.
- **Zones concernées :** `app/Http/Controllers/Api/DocumentApiController.php`, `app/Http/Controllers/UserdataController.php`.
- **Risque :** exposition de données personnelles et de documents de candidature.
- **Correction à suivre :** conserver ces documents sur un stockage privé et les servir par un contrôleur qui vérifie l’identité et les droits d’accès.
- **État :** à corriger et vérifier.

### Priorité haute — extensions des fichiers téléversés

- **Observation :** certains noms de fichiers reprennent l’extension d’origine fournie par le client et sont enregistrés dans des répertoires publics.
- **Zones concernées :** téléversements dans `app/Http/Controllers/Api/DocumentApiController.php`, `app/Http/Controllers/Api/CandidatApiController.php` et `app/Http/Controllers/UserdataController.php`.
- **Risque :** les routes API conservent l’extension d’origine; le script Nginx de production envoie les fichiers `.php` sous `public/` à PHP-FPM sans exception visible pour les répertoires de téléversement. Cela crée un risque critique potentiel d’exécution de code si un fichier passe la validation de contenu avec une extension `.php`. Ce scénario n’a pas été testé.
- **Correction à suivre :** produire un nom avec une extension déterminée côté serveur à partir d’une liste autorisée, stocker hors de la racine publique et interdire l’exécution de scripts dans les dossiers de dépôt.
- **État :** priorité critique à corriger avant exposition publique, puis vérifier en recette sans charger de code exécutable sur la production.

### Priorité moyenne — découverte des comptes par adresse e-mail

- **Observation :** la route publique `GET /check-email` retourne si une adresse e-mail existe.
- **Zone concernée :** `routes/web.php`.
- **Risque :** énumération des comptes inscrits.
- **Correction à suivre :** supprimer cette route si elle n’est pas nécessaire ou remplacer sa réponse par un comportement qui ne révèle pas l’existence du compte.
- **État :** à examiner.

### Priorité moyenne — déconnexion par requête GET

- **Observation :** la route `/logout` accepte GET et POST.
- **Zone concernée :** `routes/web.php`.
- **Risque :** une navigation externe peut provoquer une déconnexion involontaire.
- **Correction à suivre :** n’accepter que POST avec la protection CSRF standard.
- **État :** à corriger et vérifier.

### Priorité à confirmer — désérialisation du champ des rôles

- **Observation :** `Utilisateur::hasRole()` appelle `unserialize()` sur le champ `roles`.
- **Zone concernée :** `app/Models/Utilisateur.php`.
- **Risque :** la désérialisation de données non fiables peut être dangereuse. L’exposition dépend de la possibilité pour un utilisateur non privilégié de modifier ce champ et de son contenu.
- **Correction à suivre :** vérifier tous les chemins d’écriture de `roles`; préférer un format de données simple comme JSON ou désactiver l’instanciation de classes lors de la désérialisation si la compatibilité impose de conserver ce format.
- **État :** à analyser.

### Configuration de déploiement

- La configuration locale observée utilise `APP_ENV=local` et `APP_DEBUG=true`. Avant tout déploiement, confirmer que l’environnement de production utilise `APP_ENV=production` et `APP_DEBUG=false`.
- Le fichier `.env` n’est pas suivi par Git dans l’état observé. Ne jamais y recopier de secrets dans ce document ou dans un dépôt public. Renouveler tout secret réel qui aurait été exposé.
- **État :** vérifier dans l’environnement de production.

## Revue statique de la connexion — 2026-10-01

Cette revue a porté sur les mécanismes de connexion web et API visibles dans le code. Aucun mot de passe n’a été essayé et aucune requête de connexion réelle n’a été envoyée.

### Priorité haute — limitation absente sur la connexion API

- **Observation :** la route publique `POST /api/v1/auth/login` ne déclare pas de middleware `throttle` dans `routes/api.php`.
- **Zone concernée :** `routes/api.php`, connexion API de `app/Http/Controllers/Api/AuthApiController.php`.
- **Risque :** tentatives automatisées répétées de mots de passe contre des comptes.
- **Correction à suivre :** appliquer une limitation combinant adresse IP et identifiant normalisé, avec des seuils adaptés et une réponse `429`.
- **État :** à corriger et vérifier.

### Priorité moyenne — portée limitée de la limitation web

- **Observation :** la connexion web et admin limite à cinq tentatives par minute par couple identifiant saisi + adresse IP (`AppServiceProvider.php`).
- **Risque :** la rotation d’identifiants permet de multiplier les essais depuis une même IP; la rotation d’IP contourne la limite par identifiant.
- **Correction à suivre :** ajouter des limites indépendantes par IP et par identifiant normalisé, sans créer un verrouillage de compte exploitable pour empêcher le titulaire de se connecter.
- **État :** à renforcer et vérifier.

### Priorité moyenne — jetons mobiles sans expiration configurée

- **Observation :** la connexion API crée des jetons Sanctum (`AuthApiController.php`), tandis que `config/sanctum.php` définit `expiration` à `null`.
- **Risque :** un jeton volé peut rester utilisable tant qu’il n’est pas révoqué.
- **Observation associée :** le changement de mot de passe web (`AuthController::changePassword`) ne révoque pas les jetons API existants. Le flux de réinitialisation de mot de passe, lui, supprime les jetons.
- **Correction à suivre :** choisir une durée d’expiration, vérifier l’expérience de renouvellement côté mobile et révoquer les jetons lors d’un changement de mot de passe.
- **État :** à décider, corriger et vérifier.

### À confirmer — état activé des comptes administrateurs

- **Observation :** le flux de connexion admin vérifie le rôle et le blocage de sécurité, mais ne contrôle pas explicitement le champ `enabled`. Les routes admin exigent `auth` et `role:admin`, sans le middleware `enabled`.
- **Risque :** un compte administrateur marqué désactivé pourrait conserver l’accès si son blocage n’est pas enregistré dans le mécanisme de suspension distinct.
- **Correction à suivre :** confirmer la règle métier attendue pour les administrateurs désactivés, puis l’appliquer uniformément à la connexion et à l’autorisation des routes admin.
- **État :** à confirmer avec la règle d’administration.

### Priorité faible — réponses API facilitant l’énumération d’identifiants

- **Observation :** pour un identifiant inexistant et un mot de passe incorrect, les messages généraux sont proches, mais la structure du champ `errors` diffère dans `AuthApiController::login`.
- **Risque :** un client peut distinguer les comptes existants des identifiants inconnus.
- **Correction à suivre :** uniformiser le statut, le message et la structure des réponses d’échec de connexion.
- **État :** à corriger.

### Protections observées

- Les formulaires de connexion web et admin utilisent une réponse générique lorsque les identifiants sont incorrects.
- Les mots de passe bcrypt sont vérifiés avec le mécanisme de hachage Laravel; les anciens hachages Symfony sont migrés vers bcrypt après une connexion réussie.
- L’identifiant de session web est régénéré après une connexion réussie.
- Les routes d’administration sont protégées par le middleware d’authentification et le contrôle du rôle administrateur.

Ces protections n’annulent pas les constats précédents. La revue est statique : la configuration effective du serveur et des essais contrôlés en recette restent à vérifier.

## Revue des ports et de l’accès admin — 2026-10-01

Cette revue combine une lecture des fichiers de déploiement avec un relevé local des ports TCP en écoute. Elle n’a envoyé aucune requête vers un hôte distant et n’a pas tenté de se connecter à l’administration.

### Priorité haute — serveur PHP de développement à l’écoute sur toutes les interfaces

- **Observation locale :** le processus PHP écoute sur `0.0.0.0:8000`, c’est-à-dire toutes les interfaces IPv4 de cette machine, et non uniquement `127.0.0.1`.
- **Risque :** le site de développement peut être joignable depuis d’autres machines du réseau si le pare-feu autorise ces connexions. L’interface admin peut alors être atteinte au niveau réseau, même si ses pages restent protégées par authentification et rôle.
- **Limite de vérification :** l’état du pare-feu Windows n’a pas pu être lu avec les permissions disponibles; l’accessibilité depuis le réseau n’est donc pas confirmée.
- **Correction à suivre :** en développement, lier le serveur à `127.0.0.1`; ne jamais publier le serveur PHP de développement en production. Vérifier les règles de pare-feu depuis une session autorisée.
- **État :** à vérifier sur ce poste et à corriger si l’accès LAN n’est pas voulu.

### Priorité haute — MySQL à l’écoute sur toutes les interfaces locales

- **Observation locale :** le processus MySQL écoute sur `0.0.0.0:3306`.
- **Risque :** si le pare-feu ou le réseau autorise l’accès, le service de base de données est exposé au réseau. Le script de production configure MySQL sur `127.0.0.1`, mais cela ne confirme pas la configuration du poste local ni celle d’un autre serveur.
- **Correction à suivre :** limiter MySQL à l’interface locale (`127.0.0.1`) lorsque les clients distants ne sont pas requis; sinon, restreindre l’accès par pare-feu à des adresses explicitement autorisées.
- **État :** à vérifier et corriger si l’accès distant n’est pas requis.

### Priorité haute — script de déploiement configurant un site HTTP sans TLS visible

- **Observation :** `setup-server.sh` écrit une URL d’application en `http://` et génère un bloc Nginx qui écoute sur le port 80 uniquement. Le script annonce néanmoins l’ouverture du profil UFW « Nginx Full », qui inclut aussi le port 443. Aucun certificat ni bloc Nginx TLS n’est configuré dans ce script.
- **Risque :** si ce script est utilisé tel quel sans terminaison TLS externe, les identifiants de connexion et les cookies de session peuvent circuler sans chiffrement sur le réseau.
- **Correction à suivre :** installer et renouveler un certificat TLS, écouter sur 443, rediriger HTTP vers HTTPS et configurer `APP_URL` en `https://`. Vérifier séparément toute terminaison TLS fournie par un proxy externe.
- **État :** à corriger ou à confirmer avec l’architecture d’hébergement.

### Priorité haute — règles UFW ajoutées sans activation explicite ni politique entrante

- **Observation :** le script de déploiement ajoute des autorisations SSH et Nginx, mais ne configure pas explicitement une politique entrante par défaut ni l’activation du pare-feu UFW.
- **Risque :** ces commandes seules ne garantissent pas que les autres ports soient bloqués; le résultat dépend de l’état et de la politique UFW préexistants.
- **Correction à suivre :** définir une politique entrante par défaut restrictive, autoriser explicitement les seuls services nécessaires, puis activer UFW après validation de l’accès SSH. Vérifier aussi le pare-feu du fournisseur d’hébergement.
- **État :** à corriger dans le script et à vérifier sur chaque serveur.

### Priorité moyenne — secret fixe pour contourner le mode maintenance

- **Observation :** `deploy.sh` utilise une valeur de contournement statique pour `php artisan down`, inscrite dans le dépôt.
- **Risque :** toute personne connaissant cette valeur peut accéder à l’application pendant le mode maintenance, ce qui réduit sa protection lors d’un déploiement.
- **Correction à suivre :** supprimer le contournement si inutile; sinon, générer un secret fort et temporaire hors du dépôt, puis le renouveler après chaque déploiement.
- **État :** à corriger.

### Contrôle d’accès à l’administration

- Les routes `/admin/*` sont regroupées derrière `auth` et `role:admin` dans `routes/web.php`.
- Le formulaire public `/admin/login` ne suffit pas à donner accès aux pages d’administration : le code vérifie le rôle avant de connecter l’utilisateur comme administrateur, et l’inscription standard initialise les comptes sans rôle admin.
- La présence publique de la page de connexion admin est attendue; déplacer ou masquer son URL ne remplacerait pas les contrôles d’accès.
- L’accès réseau au serveur, l’état effectif du pare-feu et les règles du fournisseur restent à vérifier depuis l’environnement hébergé.

## Revue ciblée des attaques contre l’administration — 2026-10-01

Cette revue statique a ciblé les actions et protections des routes d’administration. Aucune tentative d’exploitation n’a été effectuée.

### Priorité moyenne — le blocage IP ne s’applique pas aux chemins admin

- **Observation :** le middleware `EnforceSecurityBlocks` saute explicitement le contrôle d’IP lorsque le chemin demandé commence par `/admin`. Le formulaire de blocage IP indique également qu’il vise l’espace usager.
- **Risque :** bloquer une IP depuis ce module ne l’empêche pas de continuer à atteindre la page de connexion admin et à tenter des connexions.
- **Correction à suivre :** décider si le blocage IP doit aussi protéger la connexion et l’espace admin; si oui, faire appliquer la règle avant les routes admin et prévoir une exception d’urgence maîtrisée pour éviter un verrouillage général.
- **État :** règle métier à confirmer; protection admin à renforcer si souhaitée.

### Priorité moyenne — les échecs de connexion admin ne sont pas visibles dans le journal de sécurité

- **Observation initiale :** `SecurityAccessService::recordSuccessfulLogin()` enregistrait les connexions réussies, mais pas les chemins d’échec.
- **Risque :** les tentatives répétées et les attaques par pulvérisation de mots de passe sont plus difficiles à repérer dans la page Security.
- **Correction à suivre :** journaliser les échecs avec date, IP, canal et identifiant pseudonymisé ou haché; appliquer une rétention et une limitation adaptées.
- **État :** corrigé le 2026-10-01 : succès, mot de passe refusé, compte introuvable/non activé/suspendu, accès admin refusé et limite web atteinte sont désormais enregistrés. À revalider lors d’une prochaine recette.

### Priorité haute — ajouter une authentification multifacteur pour les administrateurs

- **Observation :** aucun contrôle multifacteur n’a été repéré dans les flux de connexion admin examinés.
- **Risque :** un mot de passe administrateur compromis suffit à ouvrir une session admin, sous réserve des autres contrôles.
- **Correction à suivre :** évaluer l’ajout d’un second facteur obligatoire pour les comptes admin et prévoir des codes de récupération sécurisés.
- **État :** amélioration de sécurité à planifier.

### Priorité critique — risque de prise de contrôle serveur via téléversement API

- **Observation :** certaines routes API enregistrent les fichiers dans des dossiers sous `public/` en conservant l’extension d’origine. Le bloc Nginx généré par `setup-server.sh` transmet toute URL finissant par `.php` à PHP-FPM; aucune règle d’exclusion des dossiers `uploads` n’est visible.
- **Risque :** si la validation de contenu accepte un fichier dont le nom se termine par `.php`, le serveur pourrait exécuter ce fichier. Une compromission du processus PHP exposerait potentiellement l’application, les données et les accès administratifs.
- **Limite :** le scénario n’a pas été tenté; il faut confirmer le comportement exact de la validation Laravel et de la configuration Nginx sur une recette isolée.
- **Correction à suivre :** immédiatement empêcher l’exécution PHP dans tous les dossiers d’upload, stocker les fichiers hors de `public/`, générer une extension sûre à partir du type détecté côté serveur et réviser les fichiers déjà déposés.
- **État :** priorité critique avant mise en ligne ou maintien en ligne publique.

### Contrôles positifs observés

- Les routes d’administration sont regroupées derrière `auth` et `role:admin` dans `routes/web.php`.
- Le formulaire d’inscription fixe les rôles à une valeur sans privilège admin; `roles` n’est pas dans les champs modifiables (`fillable`) du modèle `Utilisateur`.
- Les vues admin examinées utilisent l’échappement Blade standard pour les données affichées; aucun affichage `{!! ... !!}` n’a été trouvé dans le périmètre parcouru.
- Les formulaires de modification, recrutement, blocage et déblocage observés incluent le jeton CSRF Laravel.

Les constats concernant le blocage IP et le multifacteur demandent une décision de politique d’accès. Les faiblesses de limitation des tentatives et l’absence de journalisation des échecs doivent être traitées ensemble pour rendre les attaques plus difficiles et détectables.

## Fiche à remplir pour chaque scan

Copier ce modèle à la suite du registre pour conserver l’historique :

```md
### YYYY-MM-DD — Nom du scan

- **Type :**
- **Environnement :** local / recette / production
- **Périmètre :**
- **Outil et version :**
- **Commande ou méthode :**
- **Résultat :** terminé / incomplet / bloqué
- **Constats :**
- **Faux positifs à vérifier :**
- **Corrections associées :**
- **Nouvelle vérification prévue :**
```

## Règles de suivi

1. Ne pas lancer de scan intrusif contre la production sans autorisation explicite et fenêtre convenue.
2. Utiliser un environnement de recette et des données fictives pour les tests dynamiques.
3. Ne pas enregistrer de mots de passe, clés API, jetons ou données personnelles dans ce fichier.
4. Après chaque correction, noter la méthode de vérification et le résultat, puis mettre à jour l’état du constat.
