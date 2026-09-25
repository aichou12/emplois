
@extends('layouts.app')


@section('content')


<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Connexion</title>
   <link rel="icon" href="images/dss.png" type="image/x-icon">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/pgde-form.css') }}">

   <script src="https://cdn.tailwindcss.com"></script>

</head>
</br>



<h1></h1>


<!-- Numéro d'inscription sous le bonjour, avec soulignement
<p style="text-decoration: underline; margin-top: 5px;">NUMERO INSCRIPTION: {{ Auth::user()->id }}</p>
-->
<!-- Bootstrap JS (Ajoutez-le si Bootstrap n'est pas déjà inclus) -->













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

<!-- Afficher le nom de l'utilisateur connecté et un bouton de déconnexion -->
<nav class="pgde-progress" aria-label="Progression du formulaire">
  <button type="button" class="step-indicator" id="indicator-step-1" aria-label="Étape 1 : Informations personnelles"><span class="step-indicator__number">1</span><span class="step-indicator__label">Informations personnelles</span></button>
  <span class="step-indicator__line" aria-hidden="true"></span>
  <button type="button" class="step-indicator" id="indicator-step-2" aria-label="Étape 2 : Formation"><span class="step-indicator__number">2</span><span class="step-indicator__label">Formation</span></button>
  <span class="step-indicator__line" aria-hidden="true"></span>
  <button type="button" class="step-indicator" id="indicator-step-3" aria-label="Étape 3 : Expérience"><span class="step-indicator__number">3</span><span class="step-indicator__label">Expérience</span></button>
  <span class="step-indicator__line" aria-hidden="true"></span>
  <button type="button" class="step-indicator" id="indicator-step-4" aria-label="Étape 4 : Emploi"><span class="step-indicator__number">4</span><span class="step-indicator__label">Emploi</span></button>
</nav>




<form id="userdata-edit-form" data-step-validation-url="{{ route('userdata.validate-step', $userdata->id) }}" action="{{ route('userdata.update', $userdata->id) }}" method="POST" enctype="multipart/form-data" novalidate>
@csrf
@method('PUT')

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  @include('userdata.partials.edit-personal')
  @if(false)
  <!-- Ancienne version de l'étape 1 conservée temporairement pendant la validation. -->
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
               timer: 3000,
               showConfirmButton: false
           });
       @endif

       @if($errors->any())
           Swal.fire({
               icon: 'error',
               title: 'Erreur de validation',
               html: `<ul style="text-align:left; font-size:14px; margin:0; padding-left:20px;">
                   @foreach($errors->all() as $error)
                       <li>{{ $error }}</li>
                   @endforeach
               </ul>`,
               confirmButtonColor: '#008C45'
           });
       @endif
   });
</script>

@if ($errors->any())
    <div class="alert alert-danger mb-4 shadow-sm" style="border-left: 4px solid #ED2939;">
        <h6 class="fw-bold mb-2"><i class="fas fa-exclamation-triangle me-2"></i> Veuillez corriger les erreurs suivantes :</h6>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

   <fieldset>
   <legend style="background-color: #fff; border: 2px solid green; border-radius: 8px; padding: 10px 15px; text-align: center; font-size: 1.0em; font-weight: bold; color:green; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <h3 style="margin: 0; font-family: 'Bold'; text-transform: uppercase; letter-spacing: 1px;">
      Étape 1 : Informations personnelles
    </h3>
  </legend>




 

    <!-- Aperçu de la photo de profil -->
    <div class="mb-3">
        <img id="preview" src="{{ asset($userdata->photo_profil ? $userdata->photo_profil : 'images/images.png') }}" alt="Photo de profil" width="150" height="150" class="rounded shadow-sm" style="object-fit: cover; max-height: 150px;">
    </div>

    <!-- Champ d'upload de la nouvelle photo -->
    <label for="photo_profil"><i class="fas fa-camera"></i> Changer la photo</label>
    <input type="file" id="photo_profil" name="photo_profil" accept="image/*" onchange="previewImage(event)">

<script>
    function previewImage(event) {
        if (event.target.files && event.target.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                let preview = document.getElementById('preview');
                if (preview) {
                    preview.src = e.target.result;
                }
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>

     <div class="form-group flex">
       <div class="flex-1 pr-2">
           <label for="utilisateur_id"><i class="fas fa-user" style="color:#00626D;"></i>Nom</label>
           <input type="text" class="form-control" value="{{ $userdata->utilisateur->firstname ?? 'Utilisateur inconnu' }}" readonly>
           </div>


       <div class="flex-1 pl-2">
           <label for="utilisateur_id"><i class="fas fa-user"style="color:#00626D;"></i>Prénom</label>
           <input type="text" class="form-control" value="{{ $userdata->utilisateur->lastname ?? 'Utilisateur inconnu' }}" readonly>
           </div>
     </div>


     <div class="form-group flex">
       <div class="flex-1 pr-2">
           <label for="utilisateur_id"><i class="fas fa-id-card"style="color:#00626D;"></i>CNI ou Passport</label>
           <input type="text" class="form-control" value="{{ $userdata->utilisateur->numberid ?? 'Utilisateur inconnu' }}" readonly>
           </div>
       <div class="flex-1 pl-2">
           <label for="genre"><i class="fas fa-venus-mars"style="color:#00626D;"></i>Genre</label>
           <select name="genre" id="genre" class="form-select">
                   <option value="Masculin" {{ $userdata->genre == 'Masculin' ? 'selected' : '' }}>Homme</option>
                   <option value="Feminin" {{ $userdata->genre == 'Feminin' ? 'selected' : '' }}>Femme</option>
               </select>


               </div>
           </div>
           <div class="form-group flex">
           <div class="flex-1 pr-2">
               <label for="telephone1"><i class="fas fa-phone"style="color:#00626D;"></i>Téléphone 1</label>
               <input type="text" class="form-control" id="telephone1" name="telephone1" value="{{ old('telephone1', $userdata->telephone1) }}" type="tel" pattern="[0-9]{7,15}" maxlength="15" oninput="this.value=this.value.replace(/[^0-9]/g,'')" >
            </div>
           <div class="flex-1 pl-2">
               <label for="telephone2"><i class="fas fa-phone"style="color:#00626D;"></i>Téléphone 2</label>
               <input type="text" class="form-control" id="telephone2" name="telephone2" value="{{ old('telephone2', $userdata->telephone2) }}" type="tel" pattern="[0-9]{7,15}" maxlength="15" oninput="this.value=this.value.replace(/[^0-9]/g,'')" >


                   </div>
       </div>
       <div class="form-group flex">
           <div class="flex-1 pr-2">
               <label for="datenaiss"><i class="fas fa-calendar-alt"style="color:#00626D;"></i>Date de naissance</label>
                  <input type="date" class="form-control" id="datenaiss" name="datenaiss" value="{{ $userdata->datenaiss }}" >


           </div>
           <div class="flex-1 pl-2">
               <label for="lieunaiss"><i class="fas fa-map-marker-alt"style="color:#00626D;"></i>Lieu de naissance</label>
               <input type="text" class="form-control" id="lieunaiss" name="lieunaiss" value="{{ $userdata->lieunaiss }}" >


                    </div>
       </div>
       <div class="form-group flex">
   <div class="flex-1 pr-2">
       <label for="regionnaiss_id"><i class="fas fa-calendar-alt" style="color:#00626D;"></i>Région de naissance</label>
       <select name="regionnaiss_id" id="regionnaiss_id" class="form-select">
           @foreach($regions as $region)
               <option value="{{ $region->id }}" {{ $region->id == $userdata->regionnaiss_id ? 'selected' : '' }}>
                   {{ $region->libelle }}
               </option>
           @endforeach
       </select>
   </div>
   <div class="flex-1 pl-2">
       <label for="departementnaiss_id"><i class="fas fa-map-marker-alt" style="color:#00626D;"></i>Département de naissance</label>
       <select name="departementnaiss_id" id="departementnaiss_id" class="form-select">
           <!-- Options will be loaded dynamically -->
       </select>
   </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>










    <div class="form-group flex">
       <div class="flex-1 pr-2">
           <label for="situationmatrimoniale"><i class="fa-solid fa-users" style="color:#00626D;"></i>Stuation matrimoniale</label>


           <select name="situationmatrimoniale" id="situationmatrimoniale" class="form-select">
                   <option value="Célibataire" {{ $userdata->situationmatrimoniale == 'Célibataire' ? 'selected' : '' }}>Célibataire</option>
                   <option value="Marié(e)" {{ $userdata->situationmatrimoniale == 'Marié(e)' ? 'selected' : '' }}>Marié(e)</option>
                   <option value="Divorcé(e)" {{ $userdata->situationmatrimoniale == 'Divorcé(e)' ? 'selected' : '' }}>Divorcé(e)</option>
                   <option value="Veuf/Veuve" {{ $userdata->situationmatrimoniale == 'Veuf/Veuve' ? 'selected' : '' }}>Veuf/Veuve</option>


               </select>
       </div>


       <div class="flex-1 pl-2">
           <label for="nombreenfant"><i class="fas fa-child"style="color:#00626D;"></i>Nombre d'enfants</label>
           <input type="number" class="form-control" id="nombreenfant" name="nombreenfant" value="{{ old('nombreenfant', $userdata->nombreenfant) }}" min="0" max="30" oninput="if(this.value < 0) this.value = 0; if(this.value > 30) this.value = 30;">
       </div>




   </div>
           <div class="form-group">




       </label>
    <br>




       <div class="form-group">
   <label for="lieuresidence">Lieu de Résidence</label>
   <select class="form-control" id="lieuresidence" name="lieuresidence" >
       <option value="Sénégal" {{ old('lieuresidence', $userdata->lieuresidence) == 'Sénégal' ? 'selected' : '' }}>Sénégal</option>
       <option value="Diaspora" {{ old('lieuresidence', $userdata->lieuresidence) == 'Diaspora' ? 'selected' : '' }}>Diaspora</option>
   </select> </div>






       <div class="form-group flex">
   <!-- Région de Résidence -->
   <div class="flex-1 pr-2" id="region-container">
       <label for="regionresidence_id">Région de Résidence</label>
       <select name="regionresidence_id" id="regionresidence_id" class="form-select" >
           <option value="" disabled>-- Sélectionner une région --</option>
           @foreach($regions as $region)
               <option value="{{ $region->id }}" {{ $region->id == $userdata->regionresidence_id ? 'selected' : '' }}>
                   {{ $region->libelle }}
               </option>
           @endforeach
       </select>
   </div>


   <!-- Département de Résidence -->
   <div class="flex-1 pr-2" id="departement-container">
       <label for="departementresidence_id">Département de Résidence</label>
       <select name="departementresidence_id" id="departementresidence_id" class="form-control">
           <option value="" disabled selected>-- Sélectionner un département --</option>
           @foreach($departements as $departement)
               <option value="{{ $departement->id }}" {{ $departement->id == $userdata->departementresidence_id ? 'selected' : '' }}>
                   {{ $departement->libelle }}
               </option>
           @endforeach
       </select>
   </div>
</div>






<!-- Sélection des régions -->


















   </div>








<!-- Champ handicap supplémentaire qui s'affiche uniquement si "Oui" est sélectionné -->
<div class="form-group" style="display: flex; align-items: center; gap: 20px;">
   <label for="handicap" style="margin-right: 10px;">
       <i class="fas fa-wheelchair" style="color:#00626D;"></i> Souffrez-vous d'un handicap ?
   </label>
   <div style="display: flex; gap: 20px;">
       <label for="handicap_no" style="display: flex; align-items: center; gap: 8px;">
           <input type="radio" id="handicap_no" name="handicap" value="0"
                  {{ empty($userdata->handicap_id) ? 'checked' : '' }} onclick="toggleHandicapField()">
           <span>Non</span>
       </label>
       <label for="handicap_yes" style="display: flex; align-items: center; gap: 8px;">
           <input type="radio" id="handicap_yes" name="handicap" value="1"
                  {{ !empty($userdata->handicap_id) ? 'checked' : '' }} onclick="toggleHandicapField()">
           <span>Oui</span>
       </label>
   </div>
</div>


<!-- Sélecteur de handicap (affiché si un handicap est sélectionné) -->
<div class="form-group mt-2" id="handicap_select" style="display: {{ !empty($userdata->handicap_id) ? 'block' : 'none' }};">
   <label for="handicap_id" class="fw-bold" style="color: #00626D;">Type de handicap :</label>
   <select name="handicap_id" id="handicap_id" class="form-control shadow-sm border-primary">
       <option value="">Choisir le handicap</option>
       @foreach($handicap as $handicap)
           <option value="{{ $handicap->id }}" {{ (isset($userdata->handicap_id) && $userdata->handicap_id == $handicap->id) ? 'selected' : '' }}>
               {{ $handicap->libelle }}
           </option>
       @endforeach
   </select>
</div>










   <div class="form-group flex justify-start mt-4">
     <h1></h1>






       <button type="button" class="next-step flex items-center" id = "suivant">
           <span>Suivant</span>
           <i class="fas fa-arrow-right ml-2"></i> <!-- Arrow icon (left) -->
       </button>


   </div>
   </div>


    <!-- form fields -->




    </fieldset>




















  @endif

  @include('userdata.partials.edit-formation')
  @if(false)
  <!-- Ancienne version de l'étape 2 conservée temporairement pendant la validation. -->
  <!-- Step 2: Formations (multi) -->
   <div class="form-step" id="step-2" style="display: none;">
   <fieldset>
    <legend style="background-color: #fff; border: 2px solid green; border-radius: 8px; padding: 10px 15px; text-align: center; font-size: 1.0em; font-weight: bold; color:green; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <h3 style="margin: 0; font-family: 'Bold'; text-transform: uppercase; letter-spacing: 1px;">
            Étape 2 : Formations & Diplômes
        </h3>
    </legend>

    @php
      $formList = $formations ?? [];
      if (empty($formList)) {
          $formList = [[
              'academic_id' => $userdata->academic_id == 20 ? 'sansdiplome' : (string)($userdata->academic_id ?? ''),
              'diplome' => $userdata->diplome ?? '',
              'anneediplome' => $userdata->anneediplome ?? '',
              'specialite' => $userdata->specialite ?? '',
              'etablissementdiplome' => $userdata->etablissementdiplome ?? '',
          ]];
      }
    @endphp

    <div id="formation-container" class="space-y-4">
      @foreach($formList as $i => $form)
        @php
          $currentAid = (string)($form['academic_id'] ?? '');
          $isSansDiplome = ($currentAid === '20' || $currentAid === 'sansdiplome');
        @endphp
        <div class="form-group formation-item rounded-md p-3 bg-white shadow-sm border mt-3" data-index="{{ $i }}">
          <div class="flex gap-5" style="display: flex; gap: 20px;">
            <div class="flex-1" style="flex: 1;">
              <label for="formations_{{ $i }}_academic_id">
                <i class="fas fa-graduation-cap" style="color:#00626D;"></i> Niveau de formation
                <span class="text-red-500 ml-1" style="color:red;">*</span>
              </label>
              <select name="formations[{{ $i }}][academic_id]" id="formations_{{ $i }}_academic_id"
                      class="form-control shadow-sm academic-select" required>
                <option value="" disabled {{ empty($currentAid) ? 'selected' : '' }}>-- Choisir le niveau de formation --</option>
                <option value="sansdiplome" {{ $isSansDiplome ? 'selected' : '' }}>Sans diplôme</option>
                @foreach($academins as $academin)
                  @if($academin->id != 20)
                    <option value="{{ $academin->id }}" {{ (!$isSansDiplome && $currentAid == $academin->id) ? 'selected' : '' }}>
                      {{ $academin->libelle }}
                    </option>
                  @endif
                @endforeach
              </select>
            </div>

            <div class="flex-1 degree-only" style="flex: 1; {{ $isSansDiplome ? 'display: none;' : '' }}">
              <label for="formations_{{ $i }}_diplome">
                <i class="fas fa-graduation-cap" style="color:#00626D;"></i> Intitulé diplôme
              </label>
              <input type="text" id="formations_{{ $i }}_diplome" name="formations[{{ $i }}][diplome]" value="{{ $form['diplome'] ?? '' }}" class="form-control" placeholder="Intitulé diplôme">
            </div>
          </div>

          <div class="flex gap-5 mt-3 degree-only" style="display: flex; gap: 20px; margin-top: 15px; {{ $isSansDiplome ? 'display: none !important;' : '' }}">
            <div class="flex-1" style="flex: 1;">
              <label for="formations_{{ $i }}_anneediplome">
                <i class="fas fa-calendar-check" style="color:#00626D;"></i> Année d'obtention
              </label>
              <input type="number" id="formations_{{ $i }}_anneediplome" name="formations[{{ $i }}][anneediplome]" value="{{ $form['anneediplome'] ?? '' }}" class="form-control" placeholder="Année d'obtention">
            </div>
            <div class="flex-1" style="flex: 1;">
              <label for="formations_{{ $i }}_specialite">
                <i class="fas fa-cogs" style="color:#00626D;"></i> Spécialité
              </label>
              <input type="text" id="formations_{{ $i }}_specialite" name="formations[{{ $i }}][specialite]" value="{{ $form['specialite'] ?? '' }}" class="form-control" placeholder="Spécialité">
            </div>
          </div>

          <div class="flex gap-5 mt-3 degree-only" style="display: flex; gap: 20px; margin-top: 15px; {{ $isSansDiplome ? 'display: none !important;' : '' }}">
            <div class="flex-1" style="flex: 1;">
              <label for="formations_{{ $i }}_etablissementdiplome">
                <i class="fas fa-school" style="color:#00626D;"></i> Institut
              </label>
              <input type="text" id="formations_{{ $i }}_etablissementdiplome" name="formations[{{ $i }}][etablissementdiplome]" value="{{ $form['etablissementdiplome'] ?? '' }}" class="form-control" placeholder="Institut">
            </div>
            <div class="flex-1" style="flex: 1;">
              <label for="formations_{{ $i }}_diplome_file">
                <i class="fas fa-file-alt" style="color:#00626D;"></i> Joindre un justificatif (facultatif, 8 Mo max)
              </label>
              @if(!empty($form['diplome_file']))
                <input type="hidden" id="formations_{{ $i }}_existing_diplome_file" name="formations[{{ $i }}][existing_diplome_file]" value="{{ $form['diplome_file'] }}">
                <div class="small mb-2">
                  <i class="fas fa-paperclip me-1"></i>
                  <a href="{{ asset($form['diplome_file']) }}" target="_blank">{{ basename($form['diplome_file']) }}</a>
                  <span class="text-muted">(choisir un fichier pour le remplacer)</span>
                </div>
              @endif
              <input type="file" id="formations_{{ $i }}_diplome_file" name="formations[{{ $i }}][diplome_file]" accept=".pdf,.doc,.docx,.rtf,.txt,.png,.jpg,.jpeg" class="form-control">
            </div>
          </div>

          <div class="mt-3 flex justify-end" style="margin-top: 10px; text-align: right;">
            <button type="button" class="remove-formation px-3 py-1 rounded text-white" style="background:#f56565; {{ ($loop->first && count($formList) === 1) ? 'display:none;' : '' }}">
              Supprimer
            </button>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Bouton Ajouter une formation -->
    <div id="add-formation-bar" class="mt-4" style="margin-top: 15px;">
      <button type="button" id="add-formation" class="flex items-center px-4 py-2 rounded text-white" style="background:#06843F;">
        <i class="fas fa-plus mr-2"></i> Ajouter une formation
      </button>
    </div>

    <div class="form-group flex justify-start mt-4">
        <button type="button" id="prev" class="prev-step">
            <i class="fas fa-arrow-left"> </i>
            <span>Précédent</span>
        </button>

        <button type="button" class="next-step flex items-center" id="suivant">
            <span>Suivant</span>
            <i class="fas fa-arrow-right ml-2"></i>
        </button>
    </div>
</fieldset>

<script>
(function(){
  const container = document.getElementById('formation-container');
  const addBtn = document.getElementById('add-formation');

  function tplFormation(i){
    return `
      <div class="form-group formation-item rounded-md p-3 bg-white shadow-sm border mt-3" data-index="${i}">
        <div class="flex gap-5" style="display: flex; gap: 20px;">
          <div class="flex-1" style="flex: 1;">
            <label for="formations_${i}_academic_id">
              <i class="fas fa-graduation-cap" style="color:#00626D;"></i> Niveau de formation
              <span class="text-red-500 ml-1" style="color:red;">*</span>
            </label>
            <select name="formations[${i}][academic_id]" id="formations_${i}_academic_id"
                    class="form-control shadow-sm academic-select" required>
              <option value="" disabled selected>-- Choisir le niveau de formation --</option>
              <option value="sansdiplome">Sans diplôme</option>
              @foreach($academins as $academin)
                @if($academin->id != 20)
                  <option value="{{ $academin->id }}">{{ $academin->libelle }}</option>
                @endif
              @endforeach
            </select>
          </div>

          <div class="flex-1 degree-only" style="flex: 1;">
            <label for="formations_${i}_diplome">
              <i class="fas fa-graduation-cap" style="color:#00626D;"></i> Intitulé diplôme
            </label>
            <input type="text" id="formations_${i}_diplome" name="formations[${i}][diplome]" class="form-control" placeholder="Intitulé diplôme">
          </div>
        </div>

        <div class="flex gap-5 mt-3 degree-only" style="display: flex; gap: 20px; margin-top: 15px;">
          <div class="flex-1" style="flex: 1;">
            <label for="formations_${i}_anneediplome">
              <i class="fas fa-calendar-check" style="color:#00626D;"></i> Année d'obtention
            </label>
            <input type="number" id="formations_${i}_anneediplome" name="formations[${i}][anneediplome]" class="form-control" placeholder="Année d'obtention">
          </div>
          <div class="flex-1" style="flex: 1;">
            <label for="formations_${i}_specialite">
              <i class="fas fa-cogs" style="color:#00626D;"></i> Spécialité
            </label>
            <input type="text" id="formations_${i}_specialite" name="formations[${i}][specialite]" class="form-control" placeholder="Spécialité">
          </div>
        </div>

        <div class="flex gap-5 mt-3 degree-only" style="display: flex; gap: 20px; margin-top: 15px;">
          <div class="flex-1" style="flex: 1;">
            <label for="formations_${i}_etablissementdiplome">
              <i class="fas fa-school" style="color:#00626D;"></i> Institut
            </label>
            <input type="text" id="formations_${i}_etablissementdiplome" name="formations[${i}][etablissementdiplome]" class="form-control" placeholder="Institut">
          </div>
          <div class="flex-1" style="flex: 1;">
            <label for="formations_${i}_diplome_file">
              <i class="fas fa-file-alt" style="color:#00626D;"></i> Joindre un justificatif (facultatif, 8 Mo max)
            </label>
            <input type="file" id="formations_${i}_diplome_file" name="formations[${i}][diplome_file]" accept=".pdf,.doc,.docx,.rtf,.txt,.png,.jpg,.jpeg" class="form-control">
          </div>
        </div>

        <div class="mt-3 flex justify-end" style="margin-top: 10px; text-align: right;">
          <button type="button" class="remove-formation px-3 py-1 rounded text-white" style="background:#f56565;">
            Supprimer
          </button>
        </div>
      </div>`;
  }

  function toggleDegreeFields(block){
    const select = block.querySelector('.academic-select');
    const isSans = (select && (select.value === 'sansdiplome' || select.value === '20'));
    block.querySelectorAll('.degree-only').forEach(el => {
      el.style.display = isSans ? 'none' : '';
      if (isSans){
        el.querySelectorAll('input,select,textarea').forEach(i => { i.value = ''; });
      }
    });
  }

  function reindexFormations() {
    if (!container) return;
    const items = container.querySelectorAll('.formation-item');
    items.forEach((item, idx) => {
      item.dataset.index = idx;
      const select = item.querySelector('.academic-select');
      const inputs = item.querySelectorAll('input');
      const delBtn = item.querySelector('.remove-formation');

      if (select) select.name = `formations[${idx}][academic_id]`;
      inputs.forEach(inp => {
        if (inp.type === 'file') {
          inp.name = `formations[${idx}][diplome_file]`;
          return;
        }

        if (inp.id.includes('existing_diplome_file')) {
          inp.name = `formations[${idx}][existing_diplome_file]`;
          return;
        }

        if (inp.id.includes('diplome') && !inp.id.includes('anneediplome') && !inp.id.includes('etablissementdiplome') && !inp.id.includes('diplome_file')) {
          inp.name = `formations[${idx}][diplome]`;
        } else if (inp.id.includes('anneediplome')) {
          inp.name = `formations[${idx}][anneediplome]`;
        } else if (inp.id.includes('specialite')) {
          inp.name = `formations[${idx}][specialite]`;
        } else if (inp.id.includes('etablissementdiplome')) {
          inp.name = `formations[${idx}][etablissementdiplome]`;
        }
      });
      if (delBtn) {
        delBtn.style.display = (items.length > 1) ? '' : 'none';
      }
    });
  }

  function wireBlock(block){
    const select = block.querySelector('.academic-select');
    if (select){
      select.addEventListener('change', () => toggleDegreeFields(block));
      toggleDegreeFields(block);
    }
    const delBtn = block.querySelector('.remove-formation');
    if (delBtn) {
      delBtn.addEventListener('click', () => {
        block.remove();
        reindexFormations();
      });
    }
  }

  if (container) {
    container.querySelectorAll('.formation-item').forEach(wireBlock);
    reindexFormations();
  }

  if (addBtn && container) {
    addBtn.addEventListener('click', () => {
      const i = container.querySelectorAll('.formation-item').length;
      container.insertAdjacentHTML('beforeend', tplFormation(i));
      const newBlock = container.lastElementChild;
      wireBlock(newBlock);
      reindexFormations();
    });
  }
})();
</script>















   </div>
  @endif

  @include('userdata.partials.edit-experience')
  @if(false)
  <!-- Ancienne version de l'étape 3 conservée temporairement pendant la validation. -->
  <!-- Step 3: Expérience professionnelle -->
   <div class="form-step" id="step-3" style="display: none;">
   <fieldset>
  <legend style="background-color: #fff; border: 2px solid green; border-radius: 8px; padding: 10px 15px; text-align: center; font-size: 1.0em; font-weight: bold; color:green; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <h3 style="margin: 0; font-family: 'Bold'; text-transform: uppercase; letter-spacing: 1px;">
      Étape 3 : Expérience professionnelle
    </h3>
  </legend>

  @php
    $expList = $experiences ?? [];
    if (empty($expList) && (!empty($userdata->posteoccupe) || !empty($userdata->employeur))) {
        $expList = [[
            'description' => '',
            'years' => $userdata->nombreanneeexpe ?? '',
            'poste' => $userdata->posteoccupe ?? '',
            'employeur' => $userdata->employeur ?? ''
        ]];
    }
    $hasExpVal = (!empty($expList) || !empty($userdata->posteoccupe) || !empty($userdata->employeur)) ? 'oui' : 'non';
  @endphp

  <!-- Sélection de l'expérience professionnelle -->
  <div class="form-group mt-3">
    <label for="hasExperience" style="display: inline-block; margin-right: 10px;">
      Avez-vous une expérience professionnelle ?
    </label>
    <select id="hasExperience" name="hasExperience" class="form-control" onchange="toggleExperienceFields()">
      <option value="non" {{ $hasExpVal === 'non' ? 'selected' : '' }}>Non</option>
      <option value="oui" {{ $hasExpVal === 'oui' ? 'selected' : '' }}>Oui</option>
    </select>
  </div>

  <!-- Conteneur des champs d'expérience -->
  <div id="experience-wrapper" style="{{ $hasExpVal === 'oui' ? '' : 'display: none;' }}">
    <div id="experience-container" class="space-y-4">
      @if(!empty($expList) && count($expList) > 0)
        @foreach($expList as $index => $exp)
          <div class="form-group experience-item rounded-md p-3 bg-white shadow-sm border mt-3" data-index="{{ $index }}">
            <div class="flex gap-5" style="display: flex; gap: 20px;">
              <div class="flex-1" style="flex: 1;">
                <label for="experiences_{{ $index }}_description">
                  <i class="fas fa-briefcase" style="color:#00626D;"></i> Description de l'expérience
                </label>
                <textarea id="experiences_{{ $index }}_description" name="experiences[{{ $index }}][description]" class="form-control" placeholder="Décrivez votre expérience">{{ $exp['description'] ?? '' }}</textarea>
              </div>
              <div class="flex-1" style="flex: 1;">
                <label for="experiences_{{ $index }}_years">
                  <i class="fas fa-cogs" style="color:#00626D;"></i> Nombre d'années d'expérience
                </label>
                <input type="number" id="experiences_{{ $index }}_years" name="experiences[{{ $index }}][years]" value="{{ $exp['years'] ?? '' }}" class="form-control" placeholder="Années d'expérience">
              </div>
            </div>

            <div class="flex gap-5 mt-3" style="display: flex; gap: 20px; margin-top: 15px;">
              <div class="flex-1" style="flex: 1;">
                <label for="experiences_{{ $index }}_poste">
                  <i class="fas fa-briefcase" style="color:#00626D;"></i> Poste occupé
                </label>
                <input type="text" id="experiences_{{ $index }}_poste" name="experiences[{{ $index }}][poste]" value="{{ $exp['poste'] ?? '' }}" class="form-control" placeholder="Poste occupé">
              </div>
              <div class="flex-1" style="flex: 1;">
                <label for="experiences_{{ $index }}_employeur">
                  <i class="fas fa-building" style="color:#00626D;"></i> Employeur
                </label>
                <input type="text" id="experiences_{{ $index }}_employeur" name="experiences[{{ $index }}][employeur]" value="{{ $exp['employeur'] ?? '' }}" class="form-control" placeholder="Employeur">
              </div>
            </div>

            <div class="mt-3 flex justify-end" style="margin-top: 10px; text-align: right;">
              <button type="button" class="remove-experience px-3 py-1 rounded text-white" style="background:#f56565; {{ $loop->first && count($expList) === 1 ? 'display:none;' : '' }}">
                Supprimer
              </button>
            </div>
          </div>
        @endforeach
      @else
        <div class="form-group experience-item rounded-md p-3 bg-white shadow-sm border mt-3" data-index="0">
          <div class="flex gap-5" style="display: flex; gap: 20px;">
            <div class="flex-1" style="flex: 1;">
              <label for="experiences_0_description">
                <i class="fas fa-briefcase" style="color:#00626D;"></i> Description de l'expérience
              </label>
              <textarea id="experiences_0_description" name="experiences[0][description]" class="form-control" placeholder="Décrivez votre expérience"></textarea>
            </div>
            <div class="flex-1" style="flex: 1;">
              <label for="experiences_0_years">
                <i class="fas fa-cogs" style="color:#00626D;"></i> Nombre d'années d'expérience
              </label>
              <input type="number" id="experiences_0_years" name="experiences[0][years]" class="form-control" placeholder="Années d'expérience">
            </div>
          </div>

          <div class="flex gap-5 mt-3" style="display: flex; gap: 20px; margin-top: 15px;">
            <div class="flex-1" style="flex: 1;">
              <label for="experiences_0_poste">
                <i class="fas fa-briefcase" style="color:#00626D;"></i> Poste occupé
              </label>
              <input type="text" id="experiences_0_poste" name="experiences[0][poste]" class="form-control" placeholder="Poste occupé">
            </div>
            <div class="flex-1" style="flex: 1;">
              <label for="experiences_0_employeur">
                <i class="fas fa-building" style="color:#00626D;"></i> Employeur
              </label>
              <input type="text" id="experiences_0_employeur" name="experiences[0][employeur]" class="form-control" placeholder="Employeur">
            </div>
          </div>

          <div class="mt-3 flex justify-end" style="margin-top: 10px; text-align: right;">
            <button type="button" class="remove-experience px-3 py-1 rounded text-white" style="background:#f56565; display:none;">
              Supprimer
            </button>
          </div>
        </div>
      @endif
    </div>

    <!-- Bouton Ajouter une nouvelle expérience -->
    <div id="add-experience-bar" class="mt-4">
      <button type="button" id="add-experience" class="flex items-center px-4 py-2 rounded text-white" style="background:#06843F;">
        <i class="fas fa-plus mr-2"></i> Ajouter une expérience
      </button>
    </div>
  </div>

  <div class="form-group flex justify-start mt-4">
    <!-- Bouton Précédent -->
    <button type="button" id="prev" class="prev-step">
      <i class="fas fa-arrow-left"></i>
      <span>Précédent</span>
    </button>

    <!-- Bouton Suivant -->
    <button type="button" class="next-step flex items-center" id="suivant">
      <span>Suivant</span>
      <i class="fas fa-arrow-right ml-2"></i>
    </button>
  </div>
</fieldset>

<script>
  function toggleExperienceFields() {
    const hasExp = document.getElementById('hasExperience');
    const wrapper = document.getElementById('experience-wrapper');
    if (hasExp && wrapper) {
      if (hasExp.value === 'oui') {
        wrapper.style.display = '';
      } else {
        wrapper.style.display = 'none';
      }
    }
  }
  document.addEventListener('DOMContentLoaded', toggleExperienceFields);
</script>







   </div>


  @endif

  @include('userdata.partials.edit-employment')
  @if(false)
  <!-- Ancienne version de l'étape 4 conservée temporairement pendant la validation. -->
  <!-- Step 4: Emploi -->
   <div class="form-step" id="step-4" style="display: none;">
   <fieldset>
   <legend style="background-color: #fff; border: 2px solid green; border-radius: 8px; padding: 10px 15px; text-align: center; font-size: 1.0em; font-weight: bold; color:green; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <h3 style="margin: 0; font-family: 'Bold'; text-transform: uppercase; letter-spacing: 1px;">
    Étape 4 : Emploi
    </h3>
  </legend>   <div class="mb-3">
   <label for="cv_summary" class="form-label">Résumé du CV (1000 caractères max)</label>
   <textarea id="cv_summary" name="cv_summary" class="form-control" rows="5" maxlength="1000">
       {{ old('cv_summary', $userdata->cv_summary ?? '') }}
   </textarea>
</div>


<div class="form-group">
   <label for="cv_file">
       <i class="fas fa-file-alt" style="color:#00626D;"></i> Joindre CV(8 mo max)
   </label>
   <div>
       <input type="file" class="form-control" id="cv_file" name="cv_file[]" accept=".pdf,.doc,.docx,.rtf,.txt"  onchange="updateCVList()">
       <ul id="cv_file_list"></ul>
       <!-- Champ caché pour stocker les fichiers à supprimer -->
       <input type="hidden" id="deleted_cv_files" name="deleted_cv_files" value="">
   </div>


   <!-- Liste des fichiers existants -->
<ul id="cv_existing_list" class="mt-2 list-unstyled">
        @if(isset($userdata) && $userdata->cv_file)
            @php
                $existingCvs = is_array($userdata->cv_file) ? $userdata->cv_file : json_decode($userdata->cv_file, true);
            @endphp
            @if(is_array($existingCvs))
                @foreach($existingCvs as $file)
                    <li id="file-{{ md5($file) }}" class="mb-2">
                        📄 <a href="{{ asset($file) }}" target="_blank" class="fw-bold text-dark">{{ basename($file) }}</a>
                        <button type="button" class="btn btn-sm btn-danger ms-2" onclick="removeFiles('{{ $file }}', '{{ $userdata->id }}', '{{ md5($file) }}')">
                        <i class="fas fa-trash me-1"></i> Supprimer</button>
                    </li>
                @endforeach
            @endif
        @endif
</ul>
<script>
    function removeFile(filePath, userdataId, elementId) {
    if (confirm("Voulez-vous vraiment supprimer ce fichier ?")) {
        fetch("{{ route('file.delete') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                file: filePath,
                userdata_id: userdataId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("file-" + elementId).remove();
                alert("Fichier supprimé avec succès !");
            } else {
                alert("Erreur : " + data.message);
            }
        })
        .catch(error => {
            console.error("Erreur :", error);
            alert("Une erreur est survenue.");
        });
    }
    }
</script>

<script>
    function removeFiles(filePath, userdataId, elementId) {
    if (confirm("Voulez-vous vraiment supprimer ce fichier ?")) {
        fetch("{{ route('files.delete') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                file: filePath,
                userdata_id: userdataId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("file-" + elementId).remove();
                alert("Fichier supprimé avec succès !");
            } else {
                alert("Erreur : " + data.message);
            }
        })
        .catch(error => {
            console.error("Erreur :", error);
            alert("Une erreur est survenue.");
        });
    }
    }
</script>

    <div class="form-group" style="display: flex; gap: 20px;">
       <div style="flex: 1;">
           <label for="emploi1_id" style="display: inline-block; margin-right: 10px;">
               <i class="fas fa-briefcase" style="color:#00626D;"></i>Emploi 1
           </label>
           <select name="emploi1_id" id="emploi1_id" class="form-select">
                   @foreach($emplois as $emploi)
                       <option value="{{ $emploi->id }}" {{ $emploi->id == $userdata->emploi1_id ? 'selected' : '' }}>
                           {{ $emploi->libelle }}
                       </option>
                   @endforeach
               </select>  </div>


       <div style="flex: 1;">
           <label for="anneeexperience1" style="display: inline-block; margin-right: 10px;">
               <i class="fas fa-building" style="color:#00626D;"></i>Nombre d'années d'expérience
           </label>
           <input type="number" class="form-control" id="anneeexperience1" name="anneeexperience1" value="{{ $userdata->anneeexperience1 }}">


             </div>
   </div>


   <div class="form-group" style="display: flex; gap: 20px;">
       <div style="flex: 1;">
           <label for="emploi2_id" style="display: inline-block; margin-right: 10px;">
               <i class="fas fa-briefcase" style="color:#00626D;"></i>Emploi 2
           </label>
           <select name="emploi2_id" id="emploi2_id" class="form-select">
                   @foreach($emplois as $emploi)
                       <option value="{{ $emploi->id }}" {{ $emploi->id == $userdata->emploi2_id ? 'selected' : '' }}>
                           {{ $emploi->libelle }}
                       </option>
                   @endforeach
               </select>  </div>


       <div style="flex: 1;">
           <label for="anneeexperience2" style="display: inline-block; margin-right: 10px;">
               <i class="fas fa-building" style="color:#00626D;"></i>
           </label>
           <input type="number" class="form-control" id="anneeexperience2" name="anneeexperience2" value="{{ $userdata->anneeexperience2 }}">
     </div>
   </div>
  
<!-- SECTEUR 1 -->








       <div class="button-container">
   <!-- Bouton Précédent -->
  

    <div class="text-center mt-4">
            <button type="button" style="background-color:gray;" id="prev" class="prev-step"> <i class="fa fa-arrow-left"></i>Précédent</button>
        </div>
    <!-- Bouton Soumettre -->
    <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Soumettre</button>
        </div>
        
</div>
</fieldset>
   </div>
  @endif
</form>




<!-- Vérifier si le numéro est passé dans la session -->






<!-- Popup -->






<script>
   $(document).ready(function () {
       var selectedRegion = $('#regionnaiss_id').val(); // Récupère la région sélectionnée
       var selectedDepartement = '{{ $userdata->departementnaiss_id ?? '' }}'; // Récupère le département sélectionné


       function loadDepartements(regionId, selectedDepartement = null) {
           if (regionId) {
               $.ajax({
                   url: '/departements/' + regionId, // Appel AJAX pour récupérer les départements
                   type: 'GET',
                   dataType: 'json',
                   success: function (data) {
                       $('#departementnaiss_id').empty(); // Vide la liste
                       $('#departementnaiss_id').append('<option value="">Sélectionner un département</option>');


                       $.each(data, function (key, departement) {
                           var isSelected = (departement.id == selectedDepartement) ? 'selected' : '';
                           $('#departementnaiss_id').append('<option value="' + departement.id + '" ' + isSelected + '>' + departement.libelle + '</option>');
                       });
                   },
                   error: function () {
                       console.error("Erreur lors du chargement des départements.");
                   }
               });
           }
       }


       // Charger les départements et pré-sélectionner celui de l'utilisateur
       if (selectedRegion) {
           loadDepartements(selectedRegion, selectedDepartement);
       }


       // Mettre à jour les départements si la région change
       $('#regionnaiss_id').change(function () {
           loadDepartements($(this).val());
       });
   });
</script>








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


<style>
  #userdata-edit-form .btn-show-more-items {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 12px;
    padding: 8px 12px;
    border: 1px solid #dfe8e1;
    border-radius: 8px;
    background: #fff;
    color: #176b43;
    font-family: inherit;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: border-color .15s ease, background .15s ease, color .15s ease;
  }

  #userdata-edit-form .btn-show-more-items:hover,
  #userdata-edit-form .btn-show-more-items:focus-visible {
    border-color: #a9cdb6;
    background: #f3f8f4;
    color: #075c36;
  }

  #userdata-edit-form .formation-item[hidden],
  #userdata-edit-form .experience-item[hidden],
  #userdata-edit-form .btn-show-more-items[hidden] {
    display: none !important;
  }

  #userdata-edit-form .experience-item {
    min-width: 0;
    max-width: 100%;
  }

  #userdata-edit-form .experience-item .pgde-grid-2,
  #userdata-edit-form .experience-item .form-group {
    min-width: 0;
  }

  #userdata-edit-form .experience-item textarea {
    min-width: 0;
    max-width: 100%;
    resize: vertical;
  }

  @media (max-width: 768px) {
    #userdata-edit-form .experience-item .formation-item-header {
      align-items: flex-start;
      flex-wrap: wrap;
      gap: 8px;
    }

    #userdata-edit-form .experience-item .remove-experience {
      width: auto;
      max-width: 100%;
      justify-content: center;
      padding: 7px 10px;
    }

    #userdata-edit-form .experience-item .form-group label {
      flex-wrap: wrap;
      overflow-wrap: anywhere;
    }
  }

  #userdata-edit-form .pgde-action-buttons,
  #userdata-edit-form .button-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-top: 20px;
    padding-top: 14px;
    border-top: 1px solid #e5e8e2;
  }

  #userdata-edit-form .pgde-action-buttons button,
  #userdata-edit-form .button-container button {
    min-height: 40px;
    padding: 9px 16px;
    border: 1px solid transparent;
    border-radius: 8px;
    font-family: inherit;
    font-size: 13.5px;
    font-weight: 600;
    line-height: 1.2;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: background-color .18s ease, border-color .18s ease, box-shadow .18s ease, transform .18s ease;
  }

  #userdata-edit-form .pgde-action-buttons .next-step,
  #userdata-edit-form .button-container button[type="submit"] {
    color: #fff !important;
    background: #167447 !important;
    box-shadow: 0 2px 5px rgba(22, 116, 71, .16);
  }

  #userdata-edit-form .pgde-action-buttons .next-step:hover,
  #userdata-edit-form .button-container button[type="submit"]:hover {
    background: #105f39 !important;
    box-shadow: 0 4px 10px rgba(22, 116, 71, .2);
    transform: translateY(-1px);
  }

  #userdata-edit-form .pgde-action-buttons .prev-step,
  #userdata-edit-form .button-container .prev-step {
    color: #4f5b52 !important;
    background: #fff !important;
    border-color: #d9dfd8 !important;
  }

  #userdata-edit-form .pgde-action-buttons .prev-step:hover,
  #userdata-edit-form .button-container .prev-step:hover {
    color: #165c3d !important;
    background: #f3f7f3 !important;
    border-color: #9eb9a6 !important;
  }

  #userdata-edit-form .pgde-action-buttons button i,
  #userdata-edit-form .button-container button i {
    margin: 0;
  }

  #userdata-edit-form .js-edit-field-error {
    display: block;
    margin-top: 4px;
    color: #a12622;
    font-size: 12px;
  }

  @media (max-width: 520px) {
    #userdata-edit-form .pgde-action-buttons,
    #userdata-edit-form .button-container {
      gap: 8px;
    }

    #userdata-edit-form .pgde-action-buttons button,
    #userdata-edit-form .button-container button {
      padding: 9px 12px;
      font-size: 13px;
    }
  }
</style>
<script>
   document.addEventListener('DOMContentLoaded', function () {
   const steps = Array.from(document.querySelectorAll('.form-step'));
   const indicators = Array.from(document.querySelectorAll('.step-indicator'));
   const form = document.getElementById('userdata-edit-form');
   const stepErrorKeys = @json($errors->keys());
   let currentStep = 0;

   function showStep(index) {
     currentStep = Math.max(0, Math.min(index, steps.length - 1));
     steps.forEach((step, stepIndex) => {
     const active = stepIndex === currentStep;
     step.classList.toggle('active', active);
     step.style.display = active ? 'block' : 'none';
     });
     indicators.forEach((indicator, indicatorIndex) => {
     indicator.classList.toggle('active', indicatorIndex === currentStep);
     indicator.classList.toggle('completed', indicatorIndex < currentStep);
     });
   }

   const errorGroups = [
     ['regionnaiss_id', 'departementnaiss_id', 'regionresidence_id', 'departementresidence_id', 'datenaiss', 'lieunaiss', 'telephone1', 'telephone2', 'genre', 'situationmatrimoniale', 'nombreenfant', 'handicap', 'handicap_id', 'photo_profil'],
     ['formations', 'diplome_file', 'deleted_files'],
     ['hasExperience', 'experiences'],
     ['cv_summary', 'emploi1_id', 'emploi2_id', 'anneeexperience1', 'anneeexperience2']
   ];

  function belongsToStep(key, stepIndex) {
     return errorGroups[stepIndex].some(prefix => key === prefix || key.startsWith(prefix + '.'));
   }

   const clientFieldErrors = new WeakMap();
   function clientValidationMessage(field) {
     if (field.validity.valueMissing) return 'Ce champ est obligatoire.';
     if (field.validity.rangeOverflow && field.name.includes('[anneediplome]')) return `L’année d’obtention ne peut pas dépasser ${field.max}.`;
     if (field.validity.rangeUnderflow && field.name.includes('[anneediplome]')) return `L’année d’obtention doit être au moins égale à ${field.min}.`;
     if (field.validity.rangeUnderflow && field.name.includes('[years]')) return 'Le nombre d’années d’expérience ne peut pas être négatif.';
     if (field.validity.rangeOverflow && field.name.includes('[years]')) return `Le nombre d’années d’expérience ne peut pas dépasser ${field.max} ans.`;
     if (field.validity.rangeOverflow) return `La valeur doit être inférieure ou égale à ${field.max}.`;
     if (field.validity.rangeUnderflow) return `La valeur doit être supérieure ou égale à ${field.min}.`;
     if (field.validity.typeMismatch || field.validity.patternMismatch) return 'Le format saisi n’est pas valide.';
     if (field.validity.badInput) return 'Veuillez saisir une valeur valide.';
     return 'Veuillez vérifier cette valeur.';
   }

   function updateClientFieldError(field) {
     if (!field.willValidate) return true;
     if (field.checkValidity()) {
       clientFieldErrors.get(field)?.remove();
       clientFieldErrors.delete(field);
       field.classList.remove('border-danger');
       field.removeAttribute('aria-invalid');
       return true;
     }
     let message = clientFieldErrors.get(field);
     if (!message) {
       message = document.createElement('small');
       message.className = 'js-edit-field-error';
       message.setAttribute('role', 'alert');
       field.insertAdjacentElement('afterend', message);
       clientFieldErrors.set(field, message);
     }
     message.textContent = clientValidationMessage(field);
     field.classList.add('border-danger');
     field.setAttribute('aria-invalid', 'true');
     return false;
   }

  function validateClientStep(stepNumber) {
     const step = steps[stepNumber - 1];
     const fields = Array.from(step.querySelectorAll('input, select, textarea')).filter(field => field.willValidate);
     const invalidFields = fields.filter(field => !updateClientFieldError(field));
     if (invalidFields.length) {
       revealExtraEntry(invalidFields[0]);
       invalidFields[0].focus({ preventScroll: true });
       invalidFields[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
       return false;
     }
     return true;
   }

   function revealExtraEntry(field) {
     const item = field.closest('.formation-item[hidden], .experience-item[hidden]');
     if (!item) return;
     item.closest('.form-step')?.querySelector('.btn-show-more-items:not([hidden])')?.click();
   }

   form.addEventListener('input', event => {
     if (event.target.matches('input, select, textarea') && clientFieldErrors.has(event.target)) updateClientFieldError(event.target);
   });
   form.addEventListener('change', event => {
     if (event.target.matches('input, select, textarea') && clientFieldErrors.has(event.target)) updateClientFieldError(event.target);
   });

   function showValidationErrors(stepNumber, errors) {
     const step = steps[stepNumber - 1];
     if (!step) return;

     let alert = step.querySelector('.js-step-validation-errors');
     if (!alert) {
       alert = document.createElement('div');
       alert.className = 'alert alert-danger js-step-validation-errors';
       alert.setAttribute('role', 'alert');
       step.prepend(alert);
     }

     alert.replaceChildren();
     const heading = document.createElement('strong');
     heading.textContent = 'Veuillez corriger les erreurs de cette étape :';
     alert.appendChild(heading);
     const list = document.createElement('ul');
     Object.values(errors).flat().forEach(message => {
       const item = document.createElement('li');
       item.textContent = message;
       list.appendChild(item);
     });
     alert.appendChild(list);

     step.querySelectorAll('.border-danger').forEach(field => field.classList.remove('border-danger'));
     for (const key of Object.keys(errors)) {
       const normalizedKey = key.replace(/\[(\d+)\]/g, '.$1').replace(/\]/g, '').replace(/\[/g, '.');
       const field = Array.from(step.querySelectorAll('[name]')).find(input => {
         const normalizedName = input.name.replace(/\[(\d+)\]/g, '.$1').replace(/\]/g, '').replace(/\[/g, '.');
         return normalizedName === normalizedKey;
       });
       if (field) {
         field.classList.add('border-danger');
         revealExtraEntry(field);
         field.focus({ preventScroll: true });
         break;
       }
     }
     alert.scrollIntoView({ behavior: 'smooth', block: 'center' });
   }

   async function validateStep(stepNumber) {
     const step = steps[stepNumber - 1];
     if (!validateClientStep(stepNumber)) return false;
     const payload = new FormData();
     payload.append('_token', form.querySelector('input[name="_token"]').value);
     payload.append('step', stepNumber);

     step.querySelectorAll('input, select, textarea').forEach(field => {
       if (!field.name || field.disabled) return;
       if ((field.type === 'checkbox' || field.type === 'radio') && !field.checked) return;
       if (field.type === 'file') {
         Array.from(field.files).forEach(file => payload.append(field.name, file));
       } else {
         payload.append(field.name, field.value);
       }
     });

     try {
       const response = await fetch(form.dataset.stepValidationUrl, {
         method: 'POST',
         headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
         body: payload
       });
       const result = await response.json();
       if (response.status === 422) {
         showValidationErrors(stepNumber, result.errors || { step: [result.message || 'Les informations saisies sont invalides.'] });
         return false;
       }
       if (!response.ok) throw new Error(result.message || 'La validation a échoué.');

       const alert = step.querySelector('.js-step-validation-errors');
       if (alert) alert.remove();
       step.querySelectorAll('.border-danger').forEach(field => field.classList.remove('border-danger'));
       return true;
     } catch (error) {
       showValidationErrors(stepNumber, { step: [error.message || 'Impossible de contacter le serveur. Réessayez.'] });
       return false;
     }
   }

   document.querySelectorAll('.next-step[type="button"]').forEach(button => button.addEventListener('click', async () => {
     if (currentStep >= steps.length - 1) return;
     button.disabled = true;
     try {
       if (await validateStep(currentStep + 1)) showStep(currentStep + 1);
     } finally {
       button.disabled = false;
     }
   }));
   let finalSubmissionValidated = false;
   form.addEventListener('submit', async event => {
     if (finalSubmissionValidated) return;
     event.preventDefault();

     if (currentStep < steps.length - 1) {
       if (await validateStep(currentStep + 1)) showStep(currentStep + 1);
       return;
     }

     const submitButton = event.submitter;
     if (submitButton) submitButton.disabled = true;
     try {
       if (await validateStep(currentStep + 1)) {
         finalSubmissionValidated = true;
         form.requestSubmit();
       }
     } finally {
       if (submitButton && !finalSubmissionValidated) submitButton.disabled = false;
     }
   });
   document.querySelectorAll('.prev-step').forEach(button => button.addEventListener('click', () => showStep(currentStep - 1)));
   indicators.forEach((indicator, index) => indicator.addEventListener('click', async () => {
     if (index <= currentStep) {
       showStep(index);
       return;
     }
     for (let stepNumber = currentStep + 1; stepNumber <= index; stepNumber++) {
       if (!(await validateStep(stepNumber))) {
         showStep(stepNumber - 1);
         return;
       }
     }
     showStep(index);
   }));

   const firstInvalidStep = errorGroups.findIndex((_, index) => stepErrorKeys.some(key => belongsToStep(key, index)));
   showStep(firstInvalidStep === -1 ? 0 : firstInvalidStep);
   });
</script>

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




<script>
  (function(){
    const container = document.getElementById("experience-container");
    const addBtn = document.getElementById("add-experience");

    function reindexExperiences() {
      if (!container) return;
      const items = container.querySelectorAll(".experience-item");
      items.forEach((item, idx) => {
        item.dataset.index = idx;
        const desc = item.querySelector('textarea');
        const num = item.querySelector('input[type="number"]');
        const textInputs = item.querySelectorAll('input[type="text"]');
        const delBtn = item.querySelector('.remove-experience');

        if (desc) desc.name = `experiences[${idx}][description]`;
        if (num) num.name = `experiences[${idx}][years]`;
        if (textInputs.length >= 2) {
          textInputs[0].name = `experiences[${idx}][poste]`;
          textInputs[1].name = `experiences[${idx}][employeur]`;
        }
        if (delBtn) {
          delBtn.style.display = (items.length > 1) ? '' : 'none';
        }
      });
    }

    function bindDelete(btn) {
      btn.addEventListener('click', function(){
        const item = btn.closest('.experience-item');
        if (item) {
          item.remove();
          reindexExperiences();
        }
      });
    }

    if (container) {
      container.querySelectorAll('.remove-experience').forEach(bindDelete);
      reindexExperiences();
    }

    if (addBtn && container) {
      addBtn.addEventListener("click", function () {
        const nextIndex = container.querySelectorAll(".experience-item").length;
        const newExperience = document.createElement("div");
        newExperience.className = "form-group experience-item rounded-md p-3 bg-white shadow-sm border mt-3";
        newExperience.dataset.index = nextIndex;
        newExperience.innerHTML = `
          <div class="flex gap-5" style="display: flex; gap: 20px;">
            <div class="flex-1" style="flex: 1;">
              <label for="experiences_${nextIndex}_description">
                <i class="fas fa-briefcase" style="color:#00626D;"></i> Description de l'expérience
              </label>
              <textarea id="experiences_${nextIndex}_description" name="experiences[${nextIndex}][description]" class="form-control" placeholder="Décrivez votre expérience"></textarea>
            </div>
            <div class="flex-1" style="flex: 1;">
              <label for="experiences_${nextIndex}_years">
                <i class="fas fa-cogs" style="color:#00626D;"></i> Nombre d'années d'expérience
              </label>
              <input type="number" id="experiences_${nextIndex}_years" name="experiences[${nextIndex}][years]" class="form-control" placeholder="Années d'expérience">
            </div>
          </div>

          <div class="flex gap-5 mt-3" style="display: flex; gap: 20px; margin-top: 15px;">
            <div class="flex-1" style="flex: 1;">
              <label for="experiences_${nextIndex}_poste">
                <i class="fas fa-briefcase" style="color:#00626D;"></i> Poste occupé
              </label>
              <input type="text" id="experiences_${nextIndex}_poste" name="experiences[${nextIndex}][poste]" class="form-control" placeholder="Poste occupé">
            </div>
            <div class="flex-1" style="flex: 1;">
              <label for="experiences_${nextIndex}_employeur">
                <i class="fas fa-building" style="color:#00626D;"></i> Employeur
              </label>
              <input type="text" id="experiences_${nextIndex}_employeur" name="experiences[${nextIndex}][employeur]" class="form-control" placeholder="Employeur">
            </div>
          </div>

          <div class="mt-3 flex justify-end" style="margin-top: 10px; text-align: right;">
            <button type="button" class="remove-experience px-3 py-1 rounded text-white" style="background:#f56565;">
              Supprimer
            </button>
          </div>
        `;
        container.appendChild(newExperience);
        bindDelete(newExperience.querySelector('.remove-experience'));
        reindexExperiences();
      });
    }
  })();
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
