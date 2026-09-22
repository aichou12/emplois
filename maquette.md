Système de design — Plateforme emploi, Fonction Publique
Fiche de référence pour tout nouvel écran (formulaires, tableaux de bord, pages publiques). Basée sur la charte graphique institutionnelle, adaptée aux deux premiers écrans déjà validés (formulaire de demande d'emploi, activation de compte).

Couleurs
Usage	Couleur	Code
Action principale (boutons, liens actifs, focus)	Vert institutionnel	#008C45
Survol / état actif du vert	Vert foncé	#006B35
Accent secondaire (à utiliser avec parcimonie)	Jaune institutionnel	#FFC107
Erreurs, champs invalides, alertes	Rouge	#ED2939
Texte principal	Encre	#1D1D1B
Texte secondaire, labels, aide	Gris texte	#575A7B
Bordures, séparateurs, champs	Gris bordure	#E5E5E5
Fond de page	Gris très clair	#F5F6F8
Fond des cartes / surfaces	Blanc	#FFFFFF
Panneau d'information (aide, FAQ)	Bleu très pâle	#EEF6FF
Panneau de succès	Vert très pâle	#EAF7EF
Panneau d'erreur	Rouge très pâle	#FDEDEE
Règle : le vert porte l'action principale, le jaune reste un accent ponctuel (jamais un bouton principal), le rouge est réservé aux erreurs et actions destructrices.

Typographie
Titres : Poppins, graisse 600 (semibold)
Texte courant, labels, champs : DM Sans, graisse 400–500
h1 / h2 / h3, .section-title → font-family: 'Poppins', sans-serif;
body, input, label, p        → font-family: 'DM Sans', sans-serif;
Charger les deux polices une seule fois, globalement (index.html ou fichier de styles racine) :

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
Tailles indicatives : H1 22–24px, H2/section-title 15–16px, texte courant 14,5–16px, texte secondaire/aide 12–13px.

Rayon et espacement
Rayon d'angle : 4px partout (boutons, champs, cartes, panneaux) — pas d'exception.
Zone tactile minimale des boutons : 44px de hauteur.
Espacement interne des cartes : 28–32px.
Grille de champs sur deux colonnes en desktop, une colonne sous 600px.
Composants
Boutons

Primaire : fond #008C45, texte blanc, hover #006B35
Contour (retour, annuler) : fond blanc, bordure et texte #008C45
Désactivé : opacité réduite, curseur non autorisé
Champs de formulaire

Fond blanc, bordure #E5E5E5, rayon 4px
Focus : bordure #008C45 + halo rgba(0,140,69,.14)
Libellé toujours visible au-dessus du champ (jamais seulement en placeholder)
Astérisque rouge (#ED2939) pour les champs obligatoires
Alertes / panneaux

Toujours une icône + un fond pâle + une bordure fine de la même teinte que le texte
Erreur : fond #FDEDEE, texte #8A1E27
Succès : fond #EAF7EF, texte #006B35
Information : fond #EEF6FF
Variables CSS prêtes à l'emploi
:root {
  --green: #008C45;
  --green-dark: #006B35;
  --yellow: #FFC107;
  --red: #ED2939;
  --ink: #1D1D1B;
  --ink-soft: #575A7B;
  --border: #E5E5E5;
  --bg: #F5F6F8;
  --surface: #FFFFFF;
  --info-bg: #EEF6FF;
  --success-bg: #EAF7EF;
  --error-bg: #FDEDEE;
  --radius: 4px;
}
Écrans déjà réalisés (à utiliser comme référence)
Formulaire de demande d'emploi — parcours en 4 étapes avec piste latérale numérotée
Activation de compte — carte centrée, formulaire court, panneau d'assistance
Pour tout nouvel écran : reprendre ces tokens tels quels, garder les mêmes noms de classes de composants (.form-group, .form-input, .btn-primary / .submit-btn, .alert-error / .alert-success) pour que les agents puissent réutiliser le CSS existant sans le redéfinir.