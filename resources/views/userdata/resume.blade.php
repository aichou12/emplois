



@extends('layouts.app')


@section('content')


<head>
   <!-- Ajouter le CDN Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <link rel="icon" href="{{ asset('images/dss.png') }}?v=2" type="image/x-icon">
 
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="crossorigin"/>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&amp;family=Roboto:wght@300;400;500;700&amp;display=swap"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&amp;family=Roboto:wght@300;400;500;700&amp;display=swap" media="print" onload="this.media='all'"/>
    <noscript>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&amp;family=Roboto:wght@300;400;500;700&amp;display=swap"/>
    </noscript>
   
    </head>

<!-- Barre d'en-tête -->
<header class="header-bar">
 <div class="header-content">
   <!-- Partie logo + texte République -->
   <div class="logo-section">
     <div class="flag-container">
       <img src="../../images/dss.png" alt="Drapeau du Sénégal" class="senegal-flag">
       <div class="republic-text">
         <h3>République du Sénégal</h3>
         <p>Un Peuple - Un But - Une Foi</p>
       </div>
     </div>
   </div>


   <!-- Partie titre de la plateforme -->
   <div class="title-section">
     <h3>PLATEFORME DE GESTION DES DEMANDES D’EMPLOI</h3>
   </div>
 </div>
</header>




<a href="/liste_demandeur" class="btn btn-secondary mt-4">Retour à la liste des utilisateurs</a>
  

<br>
<!-- Bootstrap JS (Ajoutez-le si Bootstrap n'est pas déjà inclus) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>














<style>






   /* Conteneur général de l’en-tête */
.header-bar {


 background-size: cover;
 padding: 15px 20px;
 border-bottom: 2px solid #ccc;
 background-color:#f5f5f5
}


/* Disposition flexible et responsive */
.header-content {
 display: flex;
 align-items: center;
 justify-content: space-between;
 flex-wrap: wrap;
 max-width: 1200px;
 margin: auto;
}


/* Partie logo et texte */
.logo-section {
 display: flex;
 align-items: center;
 gap: 15px;
 flex-wrap: wrap;
}


/* Nouveau conteneur pour empiler l'image et le texte */
.flag-container {
 display: flex;
 flex-direction: column;
 align-items: center;
 text-align: center;
}


/* Image du drapeau */
.senegal-flag {
 width: 70px; /* Taille ajustée */
 height: auto;
}


/* Texte "République du Sénégal" */
.republic-text {
 text-align: center;
}


.republic-text h3 {
 margin: 5px 0 0 0; /* Ajustement pour rapprocher du drapeau */
 font-size: 1.0rem; /* Taille réduite */
 font-weight: bold;
 color: #000;
}


.republic-text p {
 margin: 0;
 font-size: 0.7rem; /* Taille réduite */
 font-style: italic;
 color: #000;
}




/* Titre de la plateforme */
.header-bar {
 width: 100%;
 background-color: #f8f9fa; /* Fond léger pour un effet plus propre */
 padding: 20px 0; /* Ajoute un peu d'espace en haut et en bas */
}


.header-content {
 display: flex;
 flex-direction: column;
 align-items: center; /* Centre horizontalement tout le contenu */
 justify-content: center;
 text-align: center; /* Centre aussi le texte */
 width: 100%;
}


.logo-section {
 display: flex;
 flex-direction: column;
 align-items: center; /* Centre l’image et le texte */
 justify-content: center;
 text-align: center;
}


.senegal-flag {
 width: 80px; /* Ajuste la taille de l’image */
 height: auto;
 margin-bottom: 10px; /* Ajoute un petit espace sous l’image */
}


.republic-text h3 {
 font-size: 1.2rem;
 font-weight: bold;
 text-transform: uppercase;
 color: #333; /* Gris foncé pour un meilleur contraste */
}


.republic-text p {
 font-size: 0.9rem;
 color: #555; /* Texte légèrement adouci */
}


.title-section {
 display: flex;
 justify-content: center;
 align-items: center;
 width: 100%;
 margin-top: 15px; /* Espacement entre la partie logo et le titre */
 padding: 10px 20px;
}


.title-section h3 {
 font-size: 1.4rem; /* Augmente légèrement la taille */
 font-weight: 700; /* Rend le texte plus épais */
 text-transform: uppercase;
 color: #004080; /* Bleu foncé pour donner un style plus officiel */
 letter-spacing: 1px; /* Espacement entre les lettres */
 text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1); /* Effet subtil pour améliorer la lisibilité */
}






/* Responsive */
@media (max-width: 768px) {
 .header-content {
   flex-direction: column;
   align-items: center;
   text-align: center;
 }


 .senegal-flag {
   width: 55px; /* Réduction de la taille sur mobile */
 }


 .title-section h3 {
   font-size: 1.1rem;
 }
}


</style>




<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Right Resume</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="crossorigin"/>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&amp;family=Roboto:wght@300;400;500;700&amp;display=swap"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&amp;family=Roboto:wght@300;400;500;700&amp;display=swap" media="print" onload="this.media='all'"/>
    <noscript>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&amp;family=Roboto:wght@300;400;500;700&amp;display=swap"/>
    </noscript>
    <link href="{{ asset('css/font-awesome/css/all.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/aos.css') }}" rel="stylesheet">
<link href="{{ asset('css/main.css') }}" rel="stylesheet">
   <noscript>
      <style type="text/css">
        [data-aos] {
            opacity: 1 !important;
            transform: translate(0) scale(1) !important;
        }
      </style>
    </noscript>
  </head>
  <body id="top">
    
    <header class="d-print-none">
    
<div class="d-flex justify-content-end">


   </div>
</div>


<h1></h1>
<div class="d-flex justify-content-end">
  
</div>
    </header>
    <div class="page-content">
      <div class="container">
  
<div class="cover shadow-lg bg-white">
  <div class="cover-bg p-3 p-lg-4 text-white">
  
    <div class="row">
      <div class="col-lg-4 col-md-5">
      
      </div>
    
    </div>
    
  </div>
 <h1>&nbsp;</h1>
 &nbsp;


<style>
    .avatar img {
    filter: none; /* Supprime les filtres comme le noir et blanc */
}

</style>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
   <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
       <div class="d-flex">
           <div class="toast-body">
               {{ session('success') }}
           </div>
           <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
       </div>
   </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
       @if(session('success'))
           Swal.fire({
               icon: 'success',
               title: 'Succès !',
               text: "{{ session('success') }}",
               timer: 3000, // Disparait après 3 secondes
               showConfirmButton: false
           });
       @endif
   });
</script>

  <div class="about-section pt-4 px-3 px-lg-4 mt-1">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h2 class="h3 mb-4 font-weight-bold text-primary">Informations personnelles</h2>
        </div>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Date de naissance :</strong> <span class="text-secondary">{{  $utilisateur->userdata->datenaiss }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Email:</strong> <span class="text-secondary">{{  $utilisateur->userdata->email }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Téléphone:</strong> <span class="text-secondary">{{ $utilisateur->userdata->telephone1 }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Lieu de résidence :</strong> <span class="text-secondary">{{  $utilisateur->userdata->lieuresidence }}</span>
        </li>
    </ul>
</div>

<hr class="d-print-none" />

<div class="page-break"></div>

<div class="about-section pt-4 px-3 px-lg-4 mt-1">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h2 class="h3 mb-4 font-weight-bold text-primary">Formation</h2>
        </div>
    </div>

    <div class="timeline-card timeline-card-success card shadow-sm rounded-lg mb-3">
        <div class="card-body">
            @if($utilisateur->userdata->academic->libelle == 'sansdiplome')
                <div class="h5 mb-1">Sans diplôme</div>
            @else
                <div class="h5 mb-1">
                    {{ $utilisateur->userdata->academic->libelle ?? 'Non renseigné' }} 
                    <span class="text-muted h6">à {{ $utilisateur->userdata->etablissementdiplome }}</span>
                </div>
                <div class="text-muted text-small mb-2">{{ $userdata->anneediplome ?? 'Non renseigné' }}</div>
                <div class="text-muted text-small mb-2"><strong>Intitulé du diplôme :</strong> {{ $utilisateur->userdata->diplome ?? 'Non renseigné' }}</div>
                <div class="text-muted text-small mb-2"><strong>Spécialité :</strong> {{ $utilisateur->userdata->specialite ?? 'Non renseigné' }}</div>

                <!-- Vérifier si un fichier est associé au diplôme -->
                @if($utilisateur->userdata->diplome_file)
                    
                @else
                    <p class="text-muted">Aucun diplôme disponible.</p>
                @endif
            @endif
        </div>
    </div>
</div>

<!-- Modal pour afficher le PDF -->
<div class="modal fade" id="viewDiplomaModal" tabindex="-1" role="dialog" aria-labelledby="viewDiplomaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDiplomaModalLabel">Voir le diplôme</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Emplacement dynamique pour afficher le PDF -->
                <embed id="diplomaEmbed" src="" width="100%" height="500px" />
            </div>
        </div>
    </div>
</div>

<script>
    // Quand le modal est ouvert, mettre à jour l'élément embed avec l'URL du fichier
    $('#viewDiplomaModal').on('show.bs.modal', function (e) {
        var fileUrl = $(e.relatedTarget).data('file');  // Récupérer l'URL du fichier à partir de l'attribut data-file
        console.log('URL du fichier : ' + fileUrl);  // Afficher l'URL dans la console pour vérifier

        // Injecter l'URL dans l'élément embed
        $(e.currentTarget).find('#diplomaEmbed').attr('src', fileUrl);  
    });
</script>




<div class="work-experience-section px-3 px-lg-4">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h2 class="h3 mb-4 font-weight-bold text-primary">Expérience professionnelle</h2>
        </div>
    </div>

  
    <div class="timeline-card timeline-card-primary card shadow-sm rounded-lg mb-3">
        <div class="card-body">
            <!-- Vérifier si tous les champs sont vides -->
            @if(empty( $utilisateur->userdata->posteoccupe) && empty( $utilisateur->userdata->employeur) && empty( $utilisateur->userdata->experiences))
                <div class="h5 mb-1">Pas d'expérience</div>
            @else
                <!-- Afficher uniquement les champs non vides -->
                <div class="h5 mb-1">
                    @if( $utilisateur->userdata->posteoccupe)
                        {{ $utilisateur->userdata->posteoccupe }} 
                        @if( $utilisateur->userdata->employeur)
                            <span class="text-muted h6">à {{  $utilisateur->userdata->employeur }}</span>
                        @endif
                    @elseif($userdata->employeur)
                        <span class="text-muted h6">Employeur : {{  $utilisateur->userdata->employeur }}</span>
                    @elseif( $utilisateur->userdata->experiences)
                        {{  $utilisateur->userdata->experiences }}
                    @endif
                </div>

                <!-- Si le champ 'nombreanneeexpe' a une valeur -->
                @if($utilisateur->userdata->nombreanneeexpe)
                    <div class="text-muted text-small mb-2">
                        {{ $utilisateur->userdata->nombreanneeexpe }} {{  $utilisateur->userdata->nombreanneeexpe > 1 ? 'années' : 'année' }} d'expérience
                    </div>
                @endif

                <!-- Si 'experiences' est défini -->
                @if($utilisateur->userdata->experiences)
                    <div>{{  $utilisateur->userdata->experiences }}</div>
                @endif
            @endif
        </div>
    </div>
</div>


<div class="work-experience-section px-3 px-lg-4">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h2 class="h3 mb-4 font-weight-bold text-primary">Emploi</h2>
        </div>
    </div>
    <div class="timeline">
        <div class="timeline-card timeline-card-orange card shadow-sm rounded-lg mb-4">
            <div class="card-body">
                <!-- Section Résumé du CV -->
                <div class="mb-4">
                    <h6 class="text-uppercase font-weight-bold text-primary">Résumé du CV :</h6>
                    <p class="text-muted">{{  $utilisateur->userdata->cv_summary }}</p>
                </div>

                <!-- Premier secteur et emploi -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <div class="h6 font-weight-semibold">Premier secteur choisi:</div>
                            <div class="text-muted">{{ $utilisateur->userdata->emploi1->secteur->libelle }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <div class="h6 font-weight-semibold">Emploi concerné:</div>
                            <div class="text-muted">{{  $utilisateur->userdata->emploi1->libelle }}</div>
                        </div>
                    </div>
                </div>

                <!-- Deuxième secteur et emploi -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <div class="h6 font-weight-semibold">Deuxième secteur choisi:</div>
                            <div class="text-muted">{{  $utilisateur->userdata->emploi2->secteur->libelle }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <div class="h6 font-weight-semibold">Emploi concerné:</div>
                            <div class="text-muted">{{  $utilisateur->userdata->emploi2->libelle }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    </div>
    <footer class="pt-4 pb-4 text-muted text-center d-print-none">
   
    </footer>
    <script src="{{ asset('scripts/bootstrap.bundle.min.js?ver=1.2.0')}}"></script>
  
    <script src="{{ asset('scripts/aos.js?ver=1.2.0')}}"></script>
    <script src="{{ asset('scripts/main.js?ver=1.2.0')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

  </body>
</html>








<!-- Afficher le nom de l'utilisateur connecté et un bouton de déconnexion -->




   <!-- Step 1: Personal Information -->


   <div class="form-step" id="step-1">


   <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
   <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
       <div class="d-flex">
           <div class="toast-body">
               {{ session('success') }}
           </div>
           <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
       </div>
   </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
       @if(session('success'))
           Swal.fire({
               icon: 'success',
               title: 'Succès !',
               text: "{{ session('success') }}",
               timer: 3000, // Disparait après 3 secondes
               showConfirmButton: false
           });
       @endif
   });
</script>







<!-- Sélection des régions -->


















   </div>










<!-- Sélecteur de handicap (affiché si un handicap est sélectionné) -->























  



<style>
     .file-link {
   color: #00626D; /* Couleur personnalisée */
   font-weight: bold; /* Rendre le texte plus visible */
   text-decoration: none; /* Supprimer le soulignement par défaut */
}


.file-link:hover {
   color: #008B8B; /* Changer la couleur au survol */
   text-decoration: underline;
}
   .form-group {
       margin-bottom: 20px;
   }


   .form-group.flex {
       display: flex;
       justify-content: space-between;
       gap: 10px;
   }




   .radio-container {
   display: flex;
   align-items: center;
   gap: 20px; /* Espacement entre les groupes */
}


#radio-label {
   display: flex;
   align-items: center;
   gap: 5px; /* Espacement entre le bouton et le texte */
}


   .prev-step:hover, .next-step:hover {
       background-color: #45a049;
   }


   .prev-step i, .next-step i {
       margin-right: 8px;
   }


   .mr-4 {
       margin-right: 16px; /* Adds space between the buttons */
   }


   .justify-start {
       justify-content: flex-start;
   }




 .form-group.flex {
     display: flex;
     justify-content: space-between;
     gap: 10px; /* Add spacing between items */
 }


 .flex-1 {
     flex: 1;
 }


 .pr-2 {
     padding-right: 10px;
 }


 .pl-2 {
     padding-left: 10px;
 }


 .form-radio {
     accent-color: #4CAF50; /* Green accent color */
     margin-right: 10px; /* Adding space between the radio button and the label text */
 }


 .flex {
     display: flex;
 }


 .space-x-6 {
     gap: 1.5rem;
 }


 label {
     font-size: 1rem;
     color: #333;
 }


 .font-semibold {
     font-weight: 600;
 }


 .text-lg {
     font-size: 1.25rem;
 }






 .form-radio {
     accent-color: #4CAF50; /* Green accent color */
 }


 .form-select {
     width: 200px; /* Adjust width to fit the design */
     padding: 10px;
     border-radius: 8px;
     border: 1px solid #ccc;
     font-size: 1rem;
     transition: all 0.3s ease;
 }


 .form-select:focus {
     border-color: #4CAF50;
     outline: none;
     box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2);
 }


 .region-selector, .country-selector {
     display: inline-block;
     margin-top: 15px;
     background-color: #f9f9f9;
     padding: 15px;
     border-radius: 8px;
     border: 1px solid #ddd;
     box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
     margin-left: 10px;
 }






 .form-group.flex {
     display: flex;
     justify-content: space-between;
     gap: 10px; /* Add spacing between items */
 }


 .flex-1 {
     flex: 1;
 }


 .pr-2 {
     padding-right: 10px;
 }


 .pl-2 {
     padding-left: 10px;
 }


 .next-step {
     background-color: #4CAF50;
     color: white;
     padding: 10px 20px;
     border: none;
     cursor: pointer;
     font-size: 16px;
     display: inline-flex;
     align-items: center;
 }


 .next-step:hover {
     background-color: #45a049;
 }


 .next-step i {
     margin-left: 8px; /* Space between text and icon */
 }


 .justify-start {
     justify-content: flex-start;
 }


 .form-group.flex {
     display: flex;
     justify-content: space-between;
     gap: 10px; /* Add spacing between items */
 }


 .flex-1 {
     flex: 1;
 }


 .pr-2 {
     padding-right: 10px;
 }


 .pl-2 {
     padding-left: 10px;
 }


   .form-group {
       margin-bottom: 20px;
   }


   .form-group.flex {
       display: flex;
       justify-content: space-between;
       gap: 10px;
   }




   .prev-step:hover, .next-step:hover {
       background-color: #45a049;
   }


   .prev-step i, .next-step i {
       margin-right: 8px;
   }


   .mr-4 {
       margin-right: 16px; /* Adds space between the buttons */
   }


   .justify-start {
       justify-content: flex-start;
   }


   #popup {
   position: fixed;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   background-color: rgba(0, 0, 0, 0.5);
   display: none;
   align-items: center;
   justify-content: center;
}


#popup-content {
   background-color: #fff;
   padding: 20px;
   text-align: center;
   border-radius: 5px;
   max-width: 300px;
   margin: auto;
}


   /* Conteneur des boutons */
.button-container {
   display: flex;
   justify-content: space-between;
   margin-top: 20px;
}


/* Style du bouton Précédent */




/* Style du bouton Soumettre */
.submit-button {
   background-color: #007bff;
   border: none;
   padding: 10px 20px;
   font-size: 16px;
   color: #fff;
   display: flex;
   align-items: center;
   cursor: pointer;
   border-radius: 5px;
}


/* Icônes */
.submit-button i, .prev-step i {
   margin-left: 8px;
}


/* Hover Effect */
.prev-step:hover {
   background-color: #e0e0e0;
}


.submit-button:hover {
   background-color: #0056b3;
}


   body {
       font-family: Arial, sans-serif;
       background-color: #F4F4F9;
       margin: 0;
       padding: 0;
   }
   /* Barre d'en-tête */
   .header-bar {


       color: white;
       padding: 15px;
       text-align: center;
       font-size: 20px;
       font-weight: bold;
       margin-bottom: 20px;
   }
   .steps-header {
       display: flex;
       justify-content: center;
       margin-bottom: 20px;
   }
   .step-indicator {
       padding: 10px 20px;
       margin: 0 5px;
       background-color: #ccc;
       color: #333;
       border-radius: 5px;
       cursor: default;
   }
   .step-indicator.active {
       background-color: #4CAF50;
       color: #fff;
       font-weight: bold;
   }
   .styled-form {
       max-width: 800px;
       margin: 0 auto;
       background-color: #fff;
       padding: 20px;
       border-radius: 8px;
       box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
   }
   .form-step {
       display: none; /* Par défaut, caché */
   }
   .form-step.active {
       display: block; /* Afficher l’étape courante */
   }
   .styled-form h3 {
       margin-top: 0;
   }
   .styled-form div {
       margin-bottom: 15px;
   }
   label {
       font-weight: bold;
       margin-bottom: 8px;
       display: inline-block;
       color: #555;
   }
   label i {
       margin-right: 10px;
       color: #4CAF50; /* Couleur des icônes */
       font-size: 18px; /* Taille des icônes */
   }
   input[type="text"],
   input[type="number"],
   input[type="date"],
   select,
   textarea {
       width: 100%;
       padding: 10px;
       margin-top: 5px;
       border-radius: 5px;
       border: 1px solid #ddd;
       box-sizing: border-box;
   }
   input[type="text"]:focus,
   input[type="number"]:focus,
   input[type="date"]:focus,
   select:focus,
   textarea:focus {
       border-color: #4CAF50;
       outline: none;
   }
   .btn-next, .btn-prev, .btn-submit {
       background-color: #4CAF50;
       color: white;
       border: none;
       padding: 10px 20px;
       font-size: 16px;
       cursor: pointer;
       border-radius: 5px;
       margin: 5px 5px 0 0;
   }
   .btn-next:hover, .btn-prev:hover, .btn-submit:hover {
       background-color: #45A049;
   }




.id-card-photo img {
   width: 100px; /* Taille fixe pour la photo */
   height: 100px; /* Hauteur égale à la largeur */
   object-fit: cover; /* Coupe l'image pour la centrer */
   border-radius: 10%; /* Rend l'image arrondie */
   margin-bottom: 10px;
   margin-left:5px;
   margin-top:-120px;
}


.id-card-details {
   font-size: 14px; /* Taille du texte réduite */
   line-height: 1.5;
}






</style>


<style>
   /* Add your existing styles for form */
   .form-step {
       display: none;
   }


   .form-step.active {
       display: block;
   }




   .next-step:hover, .prev-step:hover {
       background-color: #45a049;
   }


   .next-step:active, .prev-step:active {
       background-color: #3e8e41;
   }
   /* Basic styling */
.form-step {
   display: none;
}


.form-step:first-of-type {
   display: block;
}


button {
   margin-top: 20px;
   padding: 10px;
}


button[type="submit"] {
   background-color: green;
   color: white;
}


button[type="button"] {
   background-color: #007bff;
   color: white;
}


   .logout-button {
       background-color: red;
       color: white;
       border: none;
       padding: 10px 20px;
       font-size: 16px;
       cursor: pointer;
       border-radius: 5px;
   }


   .logout-button:hover {
       background-color: darkred;
   }


   #suivant{
   background-color : #06843F;


   }
   #suivant:hover {
       background-color: #45a049;
   }
   #prev{
   background-color : #808080;


   }
   #prev:hover {
       background-color: #D3D3D3;
   }
</style>






<style>
   fieldset {
       border: 1px solid #ddd;
       padding: 20px;
       margin-bottom: 20px;
       border-radius: 10px;
       background-color: #fff;
       box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
   }


   legend {
       font-size: 18px;
       font-weight: bold;
       color: #333;
       margin-bottom: 10px;
   }


   .form-group {
       margin-bottom: 15px;
   }


   .form-group label {
       font-size: 14px;
       font-weight: 500;
       display: block;
       margin-bottom: 5px;
   }


   .form-group input, .form-group select, .form-group textarea {
       width: 100%;
       padding: 10px;
       border: 1px solid #ccc;
       border-radius: 5px;
       font-size: 16px;
   }


   .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
       border-color: #4CAF50;
       outline: none;
       box-shadow: 0 0 8px rgba(76, 175, 80, 0.2);
   }


   button {
       background-color: #4CAF50;
       color: white;
       border: none;
       padding: 12px 30px;
       font-size: 16px;
       cursor: pointer;
       border-radius: 5px;
       transition: background-color 0.3s;
   }


   button:hover {
       background-color: #45a049;
   }


   button:active {
       background-color: #3e8e41;
   }


   textarea {
       resize: vertical;
   }
</style>


<script>
   document.addEventListener('DOMContentLoaded', function () {
       let currentStep = 1;
       const totalSteps = 4;


       function showStep(step) {
           for (let i = 1; i <= totalSteps; i++) {
               const stepElement = document.getElementById(`step-${i}`);
               if (i === step) {
                   stepElement.classList.add('active');
               } else {
                   stepElement.classList.remove('active');
               }
           }
       }


       // Show the first step
       showStep(currentStep);


       // Next step button click
       document.querySelectorAll('.next-step').forEach(button => {
           button.addEventListener('click', function () {
               if (currentStep < totalSteps) {
                   currentStep++;
                   showStep(currentStep);
               }
           });
       });


       // Previous step button click
       document.querySelectorAll('.prev-step').forEach(button => {
           button.addEventListener('click', function () {
               if (currentStep > 1) {
                   currentStep--;
                   showStep(currentStep);
               }
           });
       });
   });
</script>
<script>
   // JavaScript to handle navigation between steps
let currentStep = 1;
const steps = document.querySelectorAll('.form-step');
const nextButtons = document.querySelectorAll('.next-step');
const prevButtons = document.querySelectorAll('.prev-step');


nextButtons.forEach(button => {
   button.addEventListener('click', () => {
       if (currentStep < steps.length) {
           steps[currentStep - 1].style.display = 'none';
           steps[currentStep].style.display = 'block';
           currentStep++;
       }
   });
});


prevButtons.forEach(button => {
   button.addEventListener('click', () => {
       if (currentStep > 1) {
           steps[currentStep - 1].style.display = 'none';
           steps[currentStep - 2].style.display = 'block';
           currentStep--;
       }
   });
});


</script>
<script>
   // Fonction pour passer à l'étape suivante
   function nextStep(step) {
       showStep(step);
   }
   // Fonction pour revenir à l'étape précédente
   function previousStep(step) {
       showStep(step);
   }
   // Fonction pour afficher une étape spécifique
   function showStep(step) {
       // Cacher toutes les étapes
       document.querySelectorAll('.form-step').forEach(stepDiv => stepDiv.classList.remove('active'));
       document.getElementById('step-' + step).classList.add('active');
       // Mettre à jour les indicateurs d'étape
       document.querySelectorAll('.step-indicator').forEach(indicator => indicator.classList.remove('active'));
       document.getElementById('indicator-step-' + step).classList.add('active');
   }
   // Ajouter un écouteur d'événement sur chaque indicateur d'étape pour naviguer en cliquant
   document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
       indicator.addEventListener('click', function() {
           showStep(index + 1);
       });
   });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function () {
       $('#regionresidence_id').change(function () {
           var regionId = $(this).val();
           if (regionId) {
               $.ajax({
                   url: '/departements/' + regionId,
                   type: 'GET',
                   dataType: 'json',
                   success: function (data) {
                       $('#departementresidence_id').empty();
                       $('#departementresidence_id').append('<option value="" disabled selected>-- Sélectionner un département --</option>');


                       $.each(data, function (key, departement) {
                           $('#departementresidence_id').append('<option value="' + departement.id + '">' + departement.libelle + '</option>');
                       });
                   },
                   error: function () {
                       alert("Erreur lors du chargement des départements.");
                   }
               });
           } else {
               $('#departementresidence_id').empty();
               $('#departementresidence_id').append('<option value="" disabled selected>-- Sélectionner un département --</option>');
           }
       });
   });
</script>


<script>
   document.addEventListener('DOMContentLoaded', function() {
       const lieuResidence = document.getElementById('lieuresidence');
       const regionContainer = document.getElementById('region-container');
       const departementContainer = document.getElementById('departement-container');


       // Fonction pour mettre à jour la visibilité des champs région et département
       function toggleRegionDepartementFields() {
           if (lieuResidence.value === 'Sénégal') {
               regionContainer.style.display = 'block';  // Afficher les champs région et département
               departementContainer.style.display = 'block';
           } else {
               regionContainer.style.display = 'none';  // Cacher les champs région et département
               departementContainer.style.display = 'none';
           }
       }


       // Vérifier la valeur initiale du champ lieu de résidence
       toggleRegionDepartementFields();


       // Ajouter un écouteur d'événements sur le changement de valeur du lieu de résidence
       lieuResidence.addEventListener('change', toggleRegionDepartementFields);
   });
</script>


<script>
   function toggleHandicapField() {
       let handicapSelect = document.getElementById('handicap_select');
       let handicapYes = document.getElementById('handicap_yes');
       handicapSelect.style.display = handicapYes.checked ? 'block' : 'none';
   }
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>




<script>
   // Met à jour la liste des CV lorsque des fichiers sont ajoutés
   function updateCVList() {
       let input = document.getElementById('cv_file');
       let fileList = document.getElementById('cv_file_list');


       // Ajouter les nouveaux fichiers sélectionnés
       for (let i = 0; i < input.files.length; i++) {
           let fileItem = document.createElement('li');
           fileItem.textContent = `📄 ${input.files[i].name}`;
           fileList.appendChild(fileItem);
       }
   }


   // Supprime un fichier de la liste et ajoute son nom au champ caché
   function removeCVFile(fileName, button) {
       let deletedFiles = document.getElementById('deleted_cv_files');
       deletedFiles.value += fileName + ';';


       // Supprime l'élément de la liste
       button.parentElement.remove();
   }
</script>




<script>
   // Met à jour la liste des diplômes en ajoutant les nouveaux fichiers sans effacer les existants
   function updateFileList() {
       let input = document.getElementById('diplome_file');
       let fileList = document.getElementById('file_list');


       // Pour chaque nouveau fichier sélectionné
       for (let i = 0; i < input.files.length; i++) {
           let file = input.files[i];


           // Optionnel : éviter d'ajouter plusieurs fois le même fichier
           if (document.getElementById('new-' + file.name)) {
               continue; // Le fichier est déjà affiché
           }


           // Créer un nouvel élément de liste pour le fichier
           let fileItem = document.createElement('li');
           fileItem.id = 'new-' + file.name; // On lui donne un id unique basé sur son nom (attention aux doublons)
           fileItem.className = "d-flex align-items-center mb-2";


           // Créer l'affichage du nom du fichier
           let fileText = document.createElement('span');
           fileText.textContent = "📄 " + file.name;


           // Créer le bouton de suppression pour le fichier
           let removeBtn = document.createElement('button');
           removeBtn.type = "button";
           removeBtn.className = "btn btn-sm btn-outline-danger ms-2";
           removeBtn.textContent = "❌ Supprimer";
           removeBtn.addEventListener('click', function() {
               removeNewFile(removeBtn);
           });


           // Assembler le tout
           fileItem.appendChild(fileText);
           fileItem.appendChild(removeBtn);
           fileList.appendChild(fileItem);
       }
   }


   // Fonction de suppression d'un fichier de la liste (nouveau fichier)
   function removeNewFile(button) {
       // Retirer l'élément <li> correspondant
       button.parentElement.remove();
   }
</script>


@endsection











