# 🚀 Feuille de Route : Refonte Progressive de la Plateforme (Espace Usager)

*Date de création : 22 Septembre 2026*  
*Objectif : Modernisation modulaire, étape par étape, de l'expérience utilisateur (UX/UI).*

---

## 🎨 Charte Graphique & Lignes Directrices
- **Couleurs principales :**
  - Vert officiel Sénégal : `#008C45` / Survol : `#006B35`
  - Jaune d'accent : `#FFC107` / `#D99F00`
  - Rouge officiel : `#ED2939`
  - Fond de page neutre : `#F5F6F8` / Surface des cartes : `#FFFFFF`
  - Bordures discrètes : `#E5E5E5`
- **Typographie :**
  - Titres et boutons d'action : `Poppins` (600 / Semi-Bold)
  - Textes courants et formulaires : `DM Sans` ou `Inter` (400-500)
- **Composants :** Rayons de courbure doux (`4px` à `8px`), ombres portées légères (`0 2px 8px rgba(0,0,0,0.04)`).

---

## 📋 Tableau de Suivi des Phases

| Phase | Module / Vue ciblée | Description & Objectifs | Statut |
| :--- | :--- | :--- | :--- |
| **Phase 1** | **Header & Layout Commun** | Harmonisation de l'en-tête officiel (logos DSS/MFP, ruban tricolore, titre responsive, capsule utilisateur, drawer mobile accessible). | ✅ Terminé |
| **Phase 2** | **Fiche Récapitulative (`summary.blade.php`)** | Modernisation de la page d'accueil du profil candidat sous forme de fiches thématiques avec actions rapides (*Modifier*, *Voir CV*). | ⏳ En attente |
| **Phase 3.1** | **Formulaires — Étape 1 : Identité & Résidence** | Alignement en grille propre des champs civils, sélecteurs dynamiques Sénégal/Diaspora et handicap. | ⏳ En attente |
| **Phase 3.2** | **Formulaires — Étape 2 : Formations & Diplômes** | Cartes dynamiques de formation avec rattachement direct de justificatifs et gestion sans diplôme. | ⏳ En attente |
| **Phase 3.3** | **Formulaires — Étape 3 : Expériences Professionnelles** | Gestion dynamique des postes occupés et sélecteur Oui/Non interactif. | ⏳ En attente |
| **Phase 3.4** | **Formulaires — Étape 4 : Emplois & CV** | Résumé de profil, sélection des secteurs/emplois avec AJAX et téléversement du document CV. | ⏳ En attente |
| **Phase 4** | **Vue CV Global (`resume.blade.php`)** | Mise en page type "CV officiel" moderne, responsive et optimisé pour l'impression/export. | ⏳ En attente |

---

## 📝 Journal des Avancements

### [22/09/2026] — Phase 1 : Header & Layout Commun (Terminé)
- Intégration des variables et tokens CSS du fichier [`maquette.md`](file:///C:/Mes%20projets/emplois/maquette.md) (`--radius: 4px`, `--green: #008C45`, `--ink`, etc.).
- Ajout du ruban tricolore officiel en haut de page.
- Harmonisation des logos institutionnels (Ministère de la Fonction Publique & DSS) avec adaptation responsive intelligente.
- Refonte de la capsule utilisateur (avatar, nom, badge N° Candidat, flèche d'état, menu déroulant stylisé).
- Création d'un Drawer latéral mobile accessible et fluide avec gestion du focus et fermeture tactile/clavier (Escape).
- Rayons de courbure fixés rigoureusement à `4px` et zones tactiles conformes (≥ 44px).

