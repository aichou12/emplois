@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Connexion</title>
   <link rel="icon" href="images/dss.png" type="image/x-icon">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

   <script src="https://cdn.tailwindcss.com"></script>

</head>


</style>
<header class="bg-white py-4 ">
    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-4 md:px-6">
        <!-- Partie gauche -->
        <div class="w-full md:w-1/4 flex flex-col items-center text-center space-y-1">
        <a href="#">
                <img src="../../images/dss.png" alt="Ministère de la Fonction Publique" class="h-10">
            </a>
            <p class="text-sm md:text-base font-bold text-gray-900">
                <a href="#" class="text-black">
                République du Sénégal
                </a>
            </p>
            <p class="pbf text-xs md:text-sm mt-0">Un peuple, Un but, Une foi</p>
        </div>

        <!-- Partie centrale : Plateforme de gestion des demandes d'emploi -->
        <div class="w-full md:w-2/4 flex justify-center items-center text-center">
        <p class="text-xl md:text-2xl font-bold text-gray-900">
    Plateforme de gestion des demandes d'emploi
</p>

        </div>

        <!-- Partie droite -->
        <div class="w-full md:w-1/4 flex flex-row items-center justify-center space-x-2">
    <a href="#">
        <img src="../../images/mfp.png" alt="Ministère de la Fonction Publique" class="h-10 md:h-28 object-contain">
    </a>
    <p class="text-sm md:text-base font-bold text-gray-900">
        <a href="#" class="text-black">
            Ministère de la Fonction Publique <br class="hidden"> Et de la Réforme du Service public
        </a>
    </p>
</div>



    </div>

</header>

</br>


<div class="d-flex justify-content-end">
    <div class="dropdown">
        <a class="btn btn-light dropdown-toggle border" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
             {{ $utilisateurConnecte->firstname }} {{ $utilisateurConnecte->lastname }}
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
    <li>
        <a href="{{ route('password.edit') }}" class="dropdown-item">Modifier le mot de passe</a>
    </li>
    <li>
        <a href="{{ route('login') }}" class="dropdown-item">
               Déconnexion
        </a>
        <form id="logout-form" action="{{ route('login') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>
</ul>

    </div>
</div>

<h1></h1>
<!-- <div class="d-flex justify-content-end">
    <div class="dropdown">
        <a class="btn btn-light border" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="underline-text">INSCRIPTION N°: {{ $utilisateurConnecte->id }}</span>
        </a>
    </div>
</div> -->

<br>
<!-- Numéro d'inscription sous le bonjour, avec soulignement
<p style="text-decoration: underline; margin-top: 5px;">NUMERO INSCRIPTION: {{ Auth::user()->id }}</p>
 -->
<!-- Bootstrap JS (Ajoutez-le si Bootstrap n'est pas déjà inclus) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>










<!-- Afficher le nom de l'utilisateur connecté et un bouton de déconnexion -->

    <!-- Step 1: Personal Information -->
    <div class="form-step" id="step-1">
    @if (session('success'))
    <p>{{ session('success') }}</p>

    @endif
    <form action="{{ route('userdata.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

<fieldset>
  <legend style="background-color: #fff; border: 2px solid green; border-radius: 8px; padding: 10px 15px; text-align: center; font-size: 1.0em; font-weight: bold; color:green; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <h3 style="margin: 0; font-family: 'Bold'; text-transform: uppercase; letter-spacing: 1px;">
      Étape 1 : Informations personnelles
    </h3>
  </legend>


<h1></h1>
<h1></h1>

      <label for="photo_profil"><i class="fas fa-camera"></i> Photo de profil</label>
      <input type="file" id="photo_profil" name="photo_profil" accept="image/*" capture="environment">


      <div class="form-group flex">
        <div class="flex-1 pr-2">
            <label for="utilisateur_id"><i class="fas fa-user" style="color:#00626D;"></i>Prénom</label>
            <input type="text" name="utilisateur_id" class="form-control" id="utilisateur_id" value=
        "{{ $utilisateurConnecte->firstname }} "
         readonly>  </div>

        <div class="flex-1 pl-2">
            <label for="utilisateur_id"><i class="fas fa-user"style="color:#00626D;"></i>Nom</label>
            <input type="text" name="utilisateur_id" class="form-control" id="utilisateur_id" value=
        "{{ $utilisateurConnecte->lastname }} "
         readonly>  </div>
      </div>

      <div class="form-group flex">
        <div class="flex-1 pr-2">
            <label for="utilisateur_id"><i class="fas fa-id-card"style="color:#00626D;"></i>Cni ou Passport</label>
            <input type="text" name="utilisateur_id" class="form-control" id="utilisateur_id" value=
        "{{ $utilisateurConnecte->numberid }} "
         readonly> </div>
        <div class="flex-1 pl-2">
            <label for="genre"><i class="fas fa-venus-mars"style="color:#00626D;"></i>Genre <span class="text-red-500 ml-1">*</span></label>
            <select id="genre" name="genre" required>
            <option value="" disabled selected>-- Choisir le sexe --</option>
            <option value="Masculin">Homme</option>
            <option value="Feminin">Femme</option>
        </select>

                </div>
            </div>
            <div class="form-group flex">
            <div class="flex-1 pr-2">
                <label for="telephone1"><i class="fas fa-phone"style="color:#00626D;"></i>Téléphone 1 <span class="text-red-500 ml-1">*</span></label>
                <input type="text" name="telephone1" id="telephone1" placeholder = "Téléphone 1" class="form-control shadow-sm" required>
                </div>
            <div class="flex-1 pl-2">
                <label for="telephone2"><i class="fas fa-phone"style="color:#00626D;"></i>Téléphone 2</label>
                <input type="text" name="telephone2" id="telephone2" placeholder = "Téléphone 2" class="form-control shadow-sm">

                    </div>
        </div>
        <div class="form-group flex">
            <div class="flex-1 pr-2">
                <label for="datenaiss"><i class="fas fa-calendar-alt"style="color:#00626D;"></i>Date de naissance <span class="text-red-500 ml-1">*</span></label>
                <input type="text" id="datenaiss" name="datenaiss" placeholder="Date de naissance" onfocus="(this.type='date')" required>
            </div>
            <div class="flex-1 pl-2">
                <label for="lieunaiss"><i class="fas fa-map-marker-alt"style="color:#00626D;"></i>Lieu de naissance <span class="text-red-500 ml-1">*</span></label>

                <input type="text" id="lieunaiss" name="lieunaiss" placeholder = "Lieu de naissance"required>
            </div>
        </div>
        <div class="form-group flex">
        <div class="flex-1 pr-2">
       <label for="regionnaiss_id"><i class="fas fa-map-marker-alt" style="color:#00626D;"></i>Région de Naissance <span class="text-red-500 ml-1">*</span></label>
       <select name="regionnaiss_id" id="regionnaiss_id" class="form-control" required>
           <option value="" disabled selected>-- Région de Naissance --</option>
           @foreach($regions as $region)
               <option value="{{ $region->id }}">{{ $region->libelle }}</option>
           @endforeach
       </select>
   </div>


   <div class="flex-1 pl-2">
       <label for="departementnaiss_id"><i class="fas fa-map-marker-alt" style="color:#00626D;"></i>Départememnt de naissance <span class="text-red-500 ml-1">*</span></label>
       <select name="departementnaiss_id" id="departementnaiss_id" class="form-control" required>
           <option value="" disabled selected>-- Département de Naissance --</option>
       </select>
   </div>
</div>



<div class="form-group flex">
       <div class="flex-1 pr-2">
           <label for="situationmatrimoniale"><i class="fa-solid fa-users" style="color:#00626D;"></i>
           Situation matrimoniale<span class="text-red-500 ml-1">*</span>
           </label>
           <select id="situationmatrimoniale" name="situationmatrimoniale" required>
           <option value="" disabled selected>-- Situation matrimoniale --</option>
               <option value="Célibataire">Célibataire</option>
               <option value="Marié(e)">Marié(e)</option>
               <option value="Divorcé(e)">Divorcé(e)</option>
               <option value="Veuf/Veuve">Veuf/Veuve</option>
           </select>

        </div>

        <div class="flex-1 pl-2">
            <label for="nombreenfant"><i class="fas fa-child"style="color:#00626D;"></i>Nombre d'enfants
            <span class="text-red-500 ml-1">*</span></label>
            <input type="number" id="nombreenfant" name="nombreenfant" placeholder = "Nombre d'enfants" required>
        </div>
</div>
            <div class="form-group">
            <div class="form-group flex">
       <div class="flex-1 pr-2">
       <label for="situationmatrimoniale"><i class="fas fa-map-marker-alt" style="color:#00626D;"></i>Où résidez-vous ?</label>
        <select name="is_abroad" id="is_abroad" class="form-control" onchange="toggleFieldsAndUpdateResidence()" required>
            <option value="" disabled selected>--Chosissez votre lieu de résidence --</option>
            <option value="0">Sénégal</option>
            <option value="1">Diaspora</option>
        </select>

        </div>

        <div class="flex-1 pl-2">

            <label for="lieuresidence"><i class="fas fa-map-marker-alt" style="color:#00626D;"></i>Lieu de Résidence<span class="text-red-500 ml-1">*</span></label>

       <input type="text" name="lieuresidence" id="lieuresidence" placeholder = "Lieu de Résidence"class="form-control shadow-sm" readonly required>
          </div>
</div>




<div class="form-group flex">
    <!-- Région de Résidence -->
    <div class="flex-1 pr-2" id="region-container">
        <label for="regionresidence_id">Région de Résidence<span class="text-red-500 ml-1">*</span></label>
        <select name="regionresidence_id" id="regionresidence_id" class="form-control">
            <option value="" disabled selected>-- Région de Résidence --</option>
            @foreach($regions as $region)
                <option value="{{ $region->id }}">{{ $region->libelle }}</option>
            @endforeach
        </select>
    </div>

    <!-- Département de Résidence -->
    <div class="flex-1 pr-2" id="departement-container">
        <label for="departementresidence_id">Département de Résidence<span class="text-red-500 ml-1">*</span></label>
        <select name="departementresidence_id" id="departementresidence_id" class="form-control">
            <option value="" disabled selected>-- Département de Résidence --</option>
        </select>
    </div>
</div>

<!-- Champs pour la Diaspora -->
<div class="form-group flex" id="diaspora-fields" style="display: none;">
    <div class="flex-1 pr-2">
        <label for="country_id">Pays de Résidence<span class="text-red-500 ml-1">*</span></label>
        <select name="country_id" id="country_id" class="form-control" >
            <option value="" disabled selected>-- Sélectionnez le pays --</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>  <!-- Assurez-vous que 'name' et 'id' sont les bons attributs -->
            @endforeach
        </select>
    </div>

    <div class="flex-1 pr-2">
        <label for="addresse">Adresse<span class="text-red-500 ml-1">*</span></label>
        <input type="text" name="addresse" id="addresse" class="form-control" >
    </div>
</div>


<script>
    function toggleFieldsAndUpdateResidence() {
        const isAbroad = document.getElementById('is_abroad').value;
        const regionField = document.getElementById('region-container');
        const departementField = document.getElementById('departement-container');
        const lieuResidenceField = document.getElementById('lieuresidence');
        const diasporaFields = document.getElementById('diaspora-fields');

        // Mise à jour de la valeur du lieu de résidence et masquage des champs en fonction de la sélection
        if (isAbroad === '1') {
            // Lieu de résidence = "Diaspora" si hors du pays
            lieuResidenceField.value = "Diaspora";
            regionField.style.display = 'none';
            departementField.style.display = 'none';
            diasporaFields.style.display = 'flex';  // Afficher les champs pour le pays et l'adresse
        } else {
            // Lieu de résidence = "Sénégal" si dans le pays
            lieuResidenceField.value = "Sénégal";
            regionField.style.display = 'block';
            departementField.style.display = 'block';
            diasporaFields.style.display = 'none';  // Masquer les champs pour le pays et l'adresse
        }
    }

    // Initialement cacher les champs région, département, et ceux pour la diaspora
    window.onload = function() {
        document.getElementById('region-container').style.display = 'none';
        document.getElementById('departement-container').style.display = 'none';
        document.getElementById('diaspora-fields').style.display = 'none';
    }
</script>



<!-- Sélection des régions -->









    </div>




 <!-- Champ handicap supplémentaire qui s'affiche uniquement si "Oui" est sélectionné -->
 <div class="form-group" style="display: flex; align-items: center; gap: 20px;">
    <label for="handicap" style="margin-right: 10px;">
        <i class="fas fa-wheelchair" style="color:#00626D;"></i> Souffrez-vous d'un handicap ?
    </label>
    <div style="display: flex; gap: 20px;">
        <label for="handicap_no" style="display: flex; align-items: center; gap: 8px;">
            <input type="radio" id="handicap_no" name="handicap" value="0" checked onclick="toggleHandicapField()">
            <span>Non</span>
        </label>
        <label for="handicap_yes" style="display: flex; align-items: center; gap: 8px;">
            <input type="radio" id="handicap_yes" name="handicap" value="1" onclick="toggleHandicapField()">
            <span>Oui</span>
        </label>
    </div>
</div>

<!-- Sélecteur de handicap (caché par défaut) -->
<div class="form-group mt-2" id="handicap_select" style="display: none;">
    <label for="handicap_id" class="fw-bold" style="color: #00626D;">Type de handicap :</label>
    <select name="handicap_id" id="handicap_id" class="form-control shadow-sm border-primary">
        <option value="">Choisir le handicap</option>
        @foreach($handicaps as $handicap)
            <option value="{{ $handicap->id }}">{{ $handicap->libelle }}</option>
        @endforeach
    </select>
</div>

<script>
    function toggleHandicapField() {
        let handicapSelect = document.getElementById('handicap_select');
        let handicapYes = document.getElementById('handicap_yes');

        if (handicapYes.checked) {
            handicapSelect.style.display = 'block'; // Afficher le select
        } else {
            handicapSelect.style.display = 'none'; // Cacher le select
        }
    }
</script>
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









<!-- Step 2: Formation (multi) -->
<div class="form-step" id="step-2" style="display:none;">
  <fieldset>
    <legend style="background-color:#fff;border:2px solid green;border-radius:8px;padding:10px 15px;text-align:center;font-size:1.0em;font-weight:bold;color:green;box-shadow:0 4px 6px rgba(0,0,0,0.1);">
      <h3 style="margin:0;font-family:'Bold';text-transform:uppercase;letter-spacing:1px;">
        Étape 2 : Formation
      </h3>
    </legend>

    <div id="formation-container" class="space-y-4">
      <!-- Bloc formation initial (index 0) -->
      <div class="form-group formation-item rounded-md p-3 bg-white shadow-sm border" data-index="0">
        <div class="flex gap-5">
          <div class="flex-1">
            <label for="formations_0_academic_id">
              <i class="fas fa-graduation-cap" style="color:#00626D;"></i> Niveau de formation
              <span class="text-red-500 ml-1">*</span>
            </label>
            <select name="formations[0][academic_id]" id="formations_0_academic_id"
                    class="form-control shadow-sm academic-select" required>
              <option value="" disabled selected>-- Choisir le niveau de formation --</option>
              <option value="sansdiplome">Sans diplôme</option>
              @foreach($academins as $academin)
                <option value="{{ $academin->id }}">{{ $academin->libelle }}</option>
              @endforeach
            </select>
          </div>

          <div class="flex-1 degree-only">
            <label for="formations_0_diplome">
              <i class="fas fa-graduation-cap" style="color:#00626D;"></i> Intitulé diplôme
            </label>
            <input type="text" id="formations_0_diplome" name="formations[0][diplome]" class="form-control" placeholder="Intitulé diplôme">
          </div>
        </div>

        <div class="flex gap-5 mt-3 degree-only">
          <div class="flex-1">
            <label for="formations_0_anneediplome">
              <i class="fas fa-calendar-check" style="color:#00626D;"></i> Année d'obtention
            </label>
            <input type="number" id="formations_0_anneediplome" name="formations[0][anneediplome]" class="form-control" placeholder="Année d'obtention">
          </div>
          <div class="flex-1">
            <label for="formations_0_specialite">
              <i class="fas fa-cogs" style="color:#00626D;"></i> Spécialité
            </label>
            <input type="text" id="formations_0_specialite" name="formations[0][specialite]" class="form-control" placeholder="Spécialité">
          </div>
        </div>

        <div class="flex gap-5 mt-3 degree-only">
          <div class="flex-1">
            <label for="formations_0_etablissementdiplome">
              <i class="fas fa-school" style="color:#00626D;"></i> Institut
            </label>
            <input type="text" id="formations_0_etablissementdiplome" name="formations[0][etablissementdiplome]" class="form-control" placeholder="Institut">
          </div>

          <!-- Fichiers mutualisés dans diplome_file[] ; si tu préfères par bloc, renomme en formations[0][diplome_file][] -->
          <div class="flex-1">
            <label for="formations_0_diplome_file">
              <i class="fas fa-file-alt" style="color:#00626D;"></i> Joindre documents (8 Mo max)
            </label>
            <input type="file" id="formations_0_diplome_file" name="diplome_file[]" accept=".pdf,.doc,.docx,.rtf,.txt" class="form-control" multiple>
          </div>
        </div>

        <div class="mt-3 flex justify-end">
          <button type="button" class="remove-formation px-3 py-2 rounded text-white" style="background:#f56565;display:none;">
            Supprimer
          </button>
        </div>
      </div>
    </div>

    <!-- Le bouton reste TOUJOURS en bas -->
    <div id="add-formation-bar" class="mt-4">
      <button type="button" id="add-formation" class="flex items-center px-4 py-2 rounded text-white" style="background:#06843F;">
        <i class="fas fa-plus mr-2"></i> Ajouter une formation
      </button>
    </div>

    <div class="form-group flex justify-start mt-4 gap-3">
      <button type="button" class="prev-step"><i class="fas fa-arrow-left"></i> <span>Précédent</span></button>
      <button type="button" class="next-step flex items-center"><span>Suivant</span> <i class="fas fa-arrow-right ml-2"></i></button>
    </div>
  </fieldset>
</div>
<script>
(function(){
  const container = document.getElementById('formation-container');
  const addBtn = document.getElementById('add-formation');

  function tplFormation(i){
    return `
      <div class="form-group formation-item rounded-md p-3 bg-white shadow-sm border" data-index="${i}">
        <div class="flex gap-5">
          <div class="flex-1">
            <label for="formations_${i}_academic_id">
              <i class="fas fa-graduation-cap" style="color:#00626D;"></i> Niveau de formation
              <span class="text-red-500 ml-1">*</span>
            </label>
            <select name="formations[${i}][academic_id]" id="formations_${i}_academic_id"
                    class="form-control shadow-sm academic-select" required>
              <option value="" disabled selected>-- Choisir le niveau de formation --</option>
              <option value="sansdiplome">Sans diplôme</option>
              @foreach($academins as $academin)
                <option value="{{ $academin->id }}">{{ $academin->libelle }}</option>
              @endforeach
            </select>
          </div>

          <div class="flex-1 degree-only">
            <label for="formations_${i}_diplome">
              <i class="fas fa-graduation-cap" style="color:#00626D;"></i> Intitulé diplôme
            </label>
            <input type="text" id="formations_${i}_diplome" name="formations[${i}][diplome]" class="form-control" placeholder="Intitulé diplôme">
          </div>
        </div>

        <div class="flex gap-5 mt-3 degree-only">
          <div class="flex-1">
            <label for="formations_${i}_anneediplome">
              <i class="fas fa-calendar-check" style="color:#00626D;"></i> Année d'obtention
            </label>
            <input type="number" id="formations_${i}_anneediplome" name="formations[${i}][anneediplome]" class="form-control" placeholder="Année d'obtention">
          </div>
          <div class="flex-1">
            <label for="formations_${i}_specialite">
              <i class="fas fa-cogs" style="color:#00626D;"></i> Spécialité
            </label>
            <input type="text" id="formations_${i}_specialite" name="formations[${i}][specialite]" class="form-control" placeholder="Spécialité">
          </div>
        </div>

        <div class="flex gap-5 mt-3 degree-only">
          <div class="flex-1">
            <label for="formations_${i}_etablissementdiplome">
              <i class="fas fa-school" style="color:#00626D;"></i> Institut
            </label>
            <input type="text" id="formations_${i}_etablissementdiplome" name="formations[${i}][etablissementdiplome]" class="form-control" placeholder="Institut">
          </div>
          <div class="flex-1">
            <label for="formations_${i}_diplome_file">
              <i class="fas fa-file-alt" style="color:#00626D;"></i> Joindre documents (8 Mo max)
            </label>
            <input type="file" id="formations_${i}_diplome_file" name="diplome_file[]" accept=".pdf,.doc,.docx,.rtf,.txt" class="form-control" multiple>
          </div>
        </div>

        <div class="mt-3 flex justify-end">
          <button type="button" class="remove-formation px-3 py-2 rounded text-white" style="background:#f56565;">
            Supprimer
          </button>
        </div>
      </div>`;
  }

  function toggleDegreeFields(block){
    const select = block.querySelector('.academic-select');
    const isSans = (select && select.value === 'sansdiplome');
    block.querySelectorAll('.degree-only').forEach(el => {
      el.style.display = isSans ? 'none' : '';
      if (isSans){
        el.querySelectorAll('input,select,textarea').forEach(i => { i.value = ''; });
      }
    });
  }

  function wireBlock(block){
    const select = block.querySelector('.academic-select');
    if (select){
      select.addEventListener('change', () => toggleDegreeFields(block));
      toggleDegreeFields(block);
    }
  }

  function addFormation(){
    const i = container.querySelectorAll('.formation-item').length;
    container.insertAdjacentHTML('beforeend', tplFormation(i)); // IMPORTANT : inside container
    const newBlock = container.lastElementChild;
    wireBlock(newBlock);
  }

  // remove (delegation)
  container.addEventListener('click', (e) => {
    if (e.target.classList.contains('remove-formation')){
      const block = e.target.closest('.formation-item');
      block.remove();
      // pas besoin de renuméroter pour le backend: PHP acceptera les clés non continues.
    }
  });

  addBtn.addEventListener('click', addFormation);
  wireBlock(container.querySelector('.formation-item[data-index="0"]'));
})();
</script>

<style>
  /* Harmonisation */
  #add-formation { background:#06843F; }
  #add-formation:hover { background:#45a049; }

  /* Optionnel : garder visuellement le bouton "toujours en bas" du step si la page est courte */
  #add-formation-bar { position: relative; }
</style>

    <!-- Step 3: Formation -->
    <div class="form-step" id="step-3" style="display:none;">
  <fieldset>
    <legend style="background-color:#fff;border:2px solid green;border-radius:8px;padding:10px 15px;text-align:center;font-size:1.0em;font-weight:bold;color:green;box-shadow:0 4px 6px rgba(0,0,0,0.1);">
      <h3 style="margin:0;font-family:'Bold';text-transform:uppercase;letter-spacing:1px;">
        Étape 3 : Expérience professionnelle
      </h3>
    </legend>

    <div class="form-group">
      <label for="hasExperience">Avez-vous de l'expérience professionnelle ?</label>
      <select id="hasExperience" name="hasExperience">
        <option value="">-- Choisir --</option>
        <option value="oui">Oui</option>
        <option value="non">Non</option>
      </select>
    </div>

    <div id="experience-wrapper" style="display:none;">
      <div id="experience-container" class="space-y-4">
        <!-- Bloc expérience initial (index 0) -->
        <div class="form-group experience-item rounded-md p-3 bg-white shadow-sm border" data-index="0">
          <div class="flex gap-5">
            <div class="flex-1">
              <label for="experiences_0_description">
                <i class="fas fa-briefcase" style="color:#00626D;"></i> Expérience professionnelle
              </label>
              <textarea id="experiences_0_description" name="experiences[0][description]" placeholder="Décrivez votre expérience" class="form-control"></textarea>
            </div>
            <div class="flex-1">
              <label for="experiences_0_years">
                <i class="fas fa-cogs" style="color:#00626D;"></i> Nombre d'années d'expérience
              </label>
              <input type="number" id="experiences_0_years" name="experiences[0][years]" class="form-control" placeholder="Années d'expérience">
            </div>
          </div>

          <div class="flex gap-5 mt-3">
            <div class="flex-1">
              <label for="experiences_0_poste">
                <i class="fas fa-briefcase" style="color:#00626D;"></i> Poste occupé
              </label>
              <input type="text" id="experiences_0_poste" name="experiences[0][poste]" class="form-control" placeholder="Poste occupé">
            </div>
            <div class="flex-1">
              <label for="experiences_0_employeur">
                <i class="fas fa-building" style="color:#00626D;"></i> Employeur
              </label>
              <input type="text" id="experiences_0_employeur" name="experiences[0][employeur]" class="form-control" placeholder="Employeur">
            </div>
          </div>

          <div class="mt-3 flex justify-end">
            <button type="button" class="remove-experience px-3 py-2 rounded text-white" style="background:#f56565;display:none;">
              Supprimer
            </button>
          </div>
        </div>
      </div>

      <!-- Le bouton reste TOUJOURS en bas -->
      <div id="add-experience-bar" class="mt-4">
        <button type="button" id="add-experience" class="flex items-center px-4 py-2 rounded text-white" style="background:#06843F;">
          <i class="fas fa-plus mr-2"></i> Ajouter une expérience
        </button>
      </div>
    </div>

    <div class="form-group flex justify-start mt-4 gap-3">
      <button type="button" class="prev-step"><i class="fas fa-arrow-left"></i> <span>Précédent</span></button>
      <button type="button" class="next-step flex items-center"><span>Suivant</span> <i class="fas fa-arrow-right ml-2"></i></button>
    </div>
  </fieldset>
</div>
<script>
(function(){
  const hasExp = document.getElementById('hasExperience');
  const wrapper = document.getElementById('experience-wrapper');
  const container = document.getElementById('experience-container');
  const addBtn = document.getElementById('add-experience');

  function tplExperience(i){
    return `
      <div class="form-group experience-item rounded-md p-3 bg-white shadow-sm border" data-index="${i}">
        <div class="flex gap-5">
          <div class="flex-1">
            <label for="experiences_${i}_description">
              <i class="fas fa-briefcase" style="color:#00626D;"></i> Expérience professionnelle
            </label>
            <textarea id="experiences_${i}_description" name="experiences[${i}][description]" class="form-control" placeholder="Décrivez votre expérience"></textarea>
          </div>
          <div class="flex-1">
            <label for="experiences_${i}_years">
              <i class="fas fa-cogs" style="color:#00626D;"></i> Nombre d'années d'expérience
            </label>
            <input type="number" id="experiences_${i}_years" name="experiences[${i}][years]" class="form-control" placeholder="Années d'expérience">
          </div>
        </div>

        <div class="flex gap-5 mt-3">
          <div class="flex-1">
            <label for="experiences_${i}_poste">
              <i class="fas fa-briefcase" style="color:#00626D;"></i> Poste occupé
            </label>
            <input type="text" id="experiences_${i}_poste" name="experiences[${i}][poste]" class="form-control" placeholder="Poste occupé">
          </div>
          <div class="flex-1">
            <label for="experiences_${i}_employeur">
              <i class="fas fa-building" style="color:#00626D;"></i> Employeur
            </label>
            <input type="text" id="experiences_${i}_employeur" name="experiences[${i}][employeur]" class="form-control" placeholder="Employeur">
          </div>
        </div>

        <div class="mt-3 flex justify-end">
          <button type="button" class="remove-experience px-3 py-2 rounded text-white" style="background:#f56565;">
            Supprimer
          </button>
        </div>
      </div>`;
  }

  function addExperience(){
    const i = container.querySelectorAll('.experience-item').length;
    container.insertAdjacentHTML('beforeend', tplExperience(i));
  }

  // toggle affichage section expériences
  hasExp.addEventListener('change', () => {
    const show = hasExp.value === 'oui';
    wrapper.style.display = show ? 'block' : 'none';
    if (!show){
      // Optionnel: vider le container (si l'utilisateur repasse à "non")
      // container.innerHTML = container.firstElementChild.outerHTML; // remet à 1 bloc
    }
  });

  // remove (delegation)
  container.addEventListener('click', (e) => {
    if (e.target.classList.contains('remove-experience')){
      const block = e.target.closest('.experience-item');
      block.remove();
    }
  });

  addBtn.addEventListener('click', addExperience);
})();
</script>






     <!-- Step 4: Emploi -->
   <div class="form-step" id="step-4" style="display: none;">
   <fieldset>
          <legend style="background-color: #fff; border: 2px solid green; border-radius: 8px; padding: 10px 15px; text-align: center; font-size: 1.0em; font-weight: bold; color:green; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <h3 style="margin: 0; font-family: 'Bold'; text-transform: uppercase; letter-spacing: 1px;">
    Étape 4 : Emploi
    </h3>
  </legend>
       <div class="mb-3">
   <label for="cv_summary" ><i class="fas fa-file-alt" style="color:#00626D;" required></i>Résumé CV</label>
   <textarea id="cv_summary" placeholder="Résumé du CV (1000 caractères max)" name="cv_summary" class="form-control" rows="5" maxlength="1000"></textarea>
</div>



       <div class="form-group">
   <label for="cv_file"><i class="fas fa-file-alt" style="color:#00626D;"></i> Joindre cv(8 mo max)</label>
   <input type="file" id="cv_file" name="cv_file[]" accept=".pdf,.doc,.docx,.rtf,.txt" class="form-control"  >
</div>



<!-- Sélection du secteur pour Emploi 1 -->
<div class="form-group mb-3">
   <label for="secteur1_id" style="display: block; margin-bottom: 5px;">
       <i class="fas fa-industry" style="color:#00626D;"></i>
   </label>
   <select name="secteur1_id" id="secteur1_id" class="form-control shadow-sm"required>
       <option value="" disabled selected>-- Choisissez le premier secteur dans lequel vous souhaitez travailler. --</option>
       @foreach($secteurs as $secteur)
           <option value="{{ $secteur->id }}">{{ $secteur->libelle }}</option>
       @endforeach
   </select>
</div>


<!-- Emploi 1 et nombre d'années d'expérience sur la même ligne -->
<div class="form-group d-flex gap-3">
   <div style="flex: 1;">
       <label for="emploi1_id" style="display: block; margin-bottom: 5px;">
           <i class="fas fa-briefcase" style="color:#00626D;"></i>
       </label>
       <select name="emploi1_id" id="emploi1_id" class="form-control shadow-sm" required>
           <option value="" disabled selected>-- Choisissez votre  emploi. --</option>
       </select>
   </div>
   <div style="flex: 1;">
       <label for="anneeexperience1" style="display: block; margin-bottom: 5px;">
           <i class="fas fa-building" style="color:#00626D;"></i>
       </label>
       <input type="number" id="anneeexperience1" name="anneeexperience1" placeholder="Nombre d'années d'expérience" class="form-control">
   </div>
</div>


<!-- Sélection du secteur pour Emploi 2 -->
<div class="form-group mb-3">
   <label for="secteur2_id" style="display: block; margin-bottom: 5px;">
       <i class="fas fa-industry" style="color:#00626D;"></i>
   </label>
   <select name="secteur2_id" id="secteur2_id" class="form-control shadow-sm" required>
       <option value="" disabled selected>-- Choisir le deuxième secteur dans lequel vous souhaitez travailler --</option>
       @foreach($secteurs as $secteur)
           <option value="{{ $secteur->id }}">{{ $secteur->libelle }}</option>
       @endforeach
   </select>
</div>


<!-- Emploi 2 et nombre d'années d'expérience sur la même ligne -->
<div class="form-group d-flex gap-3">
   <div style="flex: 1;">
       <label for="emploi2_id" style="display: block; margin-bottom: 5px;">
           <i class="fas fa-briefcase" style="color:#00626D;"></i>
       </label>
       <select name="emploi2_id" id="emploi2_id" class="form-control shadow-sm" required>
           <option value="" disabled selected>-- Choisir votre  emploi --</option>
       </select>
   </div>
   <div style="flex: 1;">
       <label for="anneeexperience2" style="display: block; margin-bottom: 5px;">
           <i class="fas fa-building" style="color:#00626D;"></i> Années d'expérience
       </label>
       <input type="number" id="anneeexperience2" name="anneeexperience2" placeholder="Nombre d'années d'expérience" class="form-control" >
   </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
   // Lorsqu'un secteur est sélectionné pour Emploi 1
   $('#secteur1_id').change(function () {
       let secteurId = $(this).val();
       let emploi1Select = $('#emploi1_id');
       emploi1Select.empty();
       emploi1Select.append('<option value="" disabled selected>Chargement...</option>');


       if (secteurId) {
           $.ajax({
               url: '/emplois-par-secteur/' + secteurId,
               type: 'GET',
               dataType: 'json',
               success: function (data) {
                   emploi1Select.empty();
                   if (data.length > 0) {
                       emploi1Select.append('<option value="" disabled selected>-- Choisir le premier emploi --</option>');
                       $.each(data, function (index, emploi) {
                           emploi1Select.append('<option value="' + emploi.id + '">' + emploi.libelle + '</option>');
                       });
                   } else {
                       emploi1Select.append('<option value="" disabled selected>Aucun emploi trouvé</option>');
                   }
               },
               error: function (xhr, status, error) {
                   console.error("Erreur AJAX pour Emploi 1:", error);
                   emploi1Select.empty();
                   emploi1Select.append('<option value="" disabled selected>Erreur de chargement</option>');
               }
           });
       } else {
           emploi1Select.html('<option value="" disabled selected>-- Choisir le premier emploi --</option>');
       }
   });


   // Lorsqu'un secteur est sélectionné pour Emploi 2
   $('#secteur2_id').change(function () {
       let secteurId = $(this).val();
       let emploi2Select = $('#emploi2_id');
       emploi2Select.empty();
       emploi2Select.append('<option value="" disabled selected>Chargement...</option>');


       if (secteurId) {
           $.ajax({
               url: '/emplois-par-secteur/' + secteurId,
               type: 'GET',
               dataType: 'json',
               success: function (data) {
                   emploi2Select.empty();
                   if (data.length > 0) {
                       emploi2Select.append('<option value="" disabled selected>-- Choisir le deuxième emploi --</option>');
                       $.each(data, function (index, emploi) {
                           emploi2Select.append('<option value="' + emploi.id + '">' + emploi.libelle + '</option>');
                       });
                   } else {
                       emploi2Select.append('<option value="" disabled selected>Aucun emploi trouvé</option>');
                   }
               },
               error: function (xhr, status, error) {
                   console.error("Erreur AJAX pour Emploi 2:", error);
                   emploi2Select.empty();
                   emploi2Select.append('<option value="" disabled selected>Erreur de chargement</option>');
               }
           });
       } else {
           emploi2Select.html('<option value="" disabled selected>-- Choisir le deuxième emploi --</option>');
       }
   });
 });
</script>



<!-- SECTEUR 1 -->








       <div class="button-container">

    <!-- Bouton Précédent -->
    <button type="button" style="background-color:gray;" id="prev" class="prev-step">
        <i class="fa fa-arrow-left"></i> Précédent
    </button>

    <!-- Bouton Soumettre -->
    <button type="submit" class="btn btn-primary shadow-sm">Soumettre</button>

    </form>








</div>
 </fieldset>
    </div>


<!-- Vérifier si le numéro est passé dans la session -->



<!-- Popup -->




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function updateDepartements(regionSelectId, departementSelectId) {
            $(regionSelectId).change(function () {
                var regionId = $(this).val();

                if (regionId) {
                    $.ajax({
                        url: '/departements/' + regionId,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            $(departementSelectId).empty();
                            $(departementSelectId).append('<option value="" disabled selected>-- Département --</option>');

                            $.each(data, function (key, departement) {
                                $(departementSelectId).append('<option value="' + departement.id + '">' + departement.libelle + '</option>');
                            });
                        },
                        error: function () {
                            alert("Erreur lors du chargement des départements.");
                        }
                    });
                } else {
                    $(departementSelectId).empty();
                    $(departementSelectId).append('<option value="" disabled selected>-- Département --</option>');
                }
            });
        }

        updateDepartements('#regionnaiss_id', '#departementnaiss_id'); // Région de Naissance
        updateDepartements('#regionresidence_id', '#departementresidence_id'); // Région de Résidence
    });
</script>

<style>
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
</style>
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

    fieldset {
        border: 1px solid #ddd;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 10px;
        background-color: #fbfbff;
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#regionnaiss_id').change(function () {
            var regionId = $(this).val();

            if (regionId) {
                $.ajax({
                    url: '/departements/' + regionId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#departementnaiss_id').empty();
                        $('#departementnaiss_id').append('<option value="" disabled selected>-- Département de Naissance --</option>');

                        $.each(data, function (key, departement) {
                            $('#departementnaiss_id').append('<option value="' + departement.id + '">' + departement.libelle + '</option>');
                        });
                    }
                });
            } else {
                $('#departementnaiss_id').empty();
                $('#departementnaiss_id').append('<option value="" disabled selected>-- Département de Naissance --</option>');
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    let currentStep = 1;
    const steps = document.querySelectorAll('.form-step');       // Toutes les étapes
    const nextButtons = document.querySelectorAll('.next-step'); // Boutons "Suivant"
    const prevButtons = document.querySelectorAll('.prev-step'); // Boutons "Précédent"
    const totalSteps = steps.length;                             // Nombre total d’étapes

    // Affiche seulement l’étape “stepNumber” et masque les autres
    function showStep(stepNumber) {
        steps.forEach((step, index) => {
            step.style.display = (index === stepNumber - 1) ? 'block' : 'none';
        });
    }

    // Vérifie si tous les champs [required] de l’étape courante sont remplis
    // Renvoie true s'ils sont tous remplis, false sinon.
    function checkRequiredFields(stepIndex) {
        const currentStepDiv = steps[stepIndex - 1];
        const requiredFields = currentStepDiv.querySelectorAll('[required]');
        let allFilled = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                allFilled = false;
                field.classList.add('border-danger');  // Mettre une bordure rouge
            } else {
                field.classList.remove('border-danger');
            }
        });

        return allFilled;
    }

    // Afficher la première étape dès le chargement
    showStep(currentStep);

    // Bouton “Suivant”
    nextButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            // 1) Vérifier les champs obligatoires de l’étape actuelle
            if (!checkRequiredFields(currentStep)) {
                alert("Veuillez remplir tous les champs obligatoires avant de continuer.");
                return; // On bloque la navigation
            }
            // 2) Si tous les champs sont remplis, on passe à l’étape suivante
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        });
    });

    // Bouton “Précédent”
    prevButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });
 });
</script>



@endsection




