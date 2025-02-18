

@extends('layouts.app')

@section('content')

<head>
    <!-- Ajouter le CDN Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<!-- Barre d'en-tête -->
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



<div class="d-flex justify-content-end">
    <div class="dropdown">
        <a class="btn btn-light dropdown-toggle border" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            Bonjour {{ $utilisateurConnecte->firstname }} {{ $utilisateurConnecte->lastname }}
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
<div class="d-flex justify-content-end">
    <div class="dropdown">
        <a class="btn btn-light border" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="underline-text">NUMERO INSCRIPTION: {{ $utilisateurConnecte->id }}</span>
        </a>
    </div>
</div>

<br>
<!-- Numéro d'inscription sous le bonjour, avec soulignement
<p style="text-decoration: underline; margin-top: 5px;">NUMERO INSCRIPTION: {{ Auth::user()->id }}</p>
 -->
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
  font-size: 0.9rem; /* Taille réduite */
  font-style: italic;
  color: #000;
}

/* Titre de la plateforme */
.title-section h3 {
  margin: 0;
  font-size: 1.0rem; /* Taille réduite */
  font-weight: bold;
  text-transform: uppercase;
  color: #000;
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





<div class="id-card">
    <div class="id-card-photo">
        <img src="{{ asset($userdata->photo_profil) }}" alt="Photo de profil">
    </div>

</div>

<!-- Afficher le nom de l'utilisateur connecté et un bouton de déconnexion -->


    <!-- Step 1: Personal Information -->

    <div class="form-step" id="step-1">

    @if (session('success'))
    <p>{{ session('success') }}</p>
@endif

<form action="{{ route('userdata.update', $userdata->id) }}" method="POST">
@csrf
@method('PUT')
    <fieldset>
      <legend><h3>Étape 1 : Informations personnelles</h3></legend>


      <div class="form-group flex">
        <div class="flex-1 pr-2">
            <label for="utilisateur_id"><i class="fas fa-user" style="color:#00626D;"></i>Nom</label>
            <input type="text" name="utilisateur_id" class="form-control" id="utilisateur_id" value=
        "{{ $utilisateurConnecte->firstname }} "
         readonly>  </div>

        <div class="flex-1 pl-2">
            <label for="utilisateur_id"><i class="fas fa-user"style="color:#00626D;"></i>Prénom</label>
            <input type="text" name="utilisateur_id" class="form-control" id="utilisateur_id" value=
        "{{ $utilisateurConnecte->lastname }} "
         readonly>  </div>
      </div>

      <div class="form-group flex">
        <div class="flex-1 pr-2">
            <label for="utilisateur_id"><i class="fas fa-id-card"style="color:#00626D;"></i>CNI</label>
            <input type="text" name="utilisateur_id" class="form-control" id="utilisateur_id" value=
        "{{ $utilisateurConnecte->numberid }} "
         readonly> </div>
        <div class="flex-1 pl-2">
            <label for="genre"><i class="fas fa-venus-mars"style="color:#00626D;"></i>Genre</label>
            <select name="genre" id="genre" class="form-select">
                    <option value="Masculin" {{ $userdata->genre == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                    <option value="Féminin" {{ $userdata->genre == 'Féminin' ? 'selected' : '' }}>Féminin</option>
                </select>

                </div>
            </div>
            <div class="form-group flex">
            <div class="flex-1 pr-2">
                <label for="telephone1"><i class="fas fa-phone"style="color:#00626D;"></i>Téléphone 1</label>
                <input type="text" class="form-control" id="telephone1" name="telephone1" value="{{ old('telephone1', $userdata->telephone1) }}" required>
             </div>
            <div class="flex-1 pl-2">
                <label for="telephone2"><i class="fas fa-phone"style="color:#00626D;"></i>Téléphone 2</label>
                <input type="text" class="form-control" id="telephone2" name="telephone2" value="{{ old('telephone2', $userdata->telephone1) }}" required>

                    </div>
        </div>
        <div class="form-group flex">
            <div class="flex-1 pr-2">
                <label for="datenaiss"><i class="fas fa-calendar-alt"style="color:#00626D;"></i>Date de naissance</label>
                   <input type="date" class="form-control" id="datenaiss" name="datenaiss" value="{{ $userdata->datenaiss }}" required>

            </div>
            <div class="flex-1 pl-2">
                <label for="lieunaiss"><i class="fas fa-map-marker-alt"style="color:#00626D;"></i>Lieu de naissance</label>
                <input type="text" class="form-control" id="lieunaiss" name="lieunaiss" value="{{ $userdata->lieunaiss }}" required>

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

<script>
    // Listen for region change
    $('#regionnaiss_id').on('change', function() {
        var region_id = $(this).val();

        // Make AJAX request to fetch departments based on selected region
        $.ajax({
            url: '/departements/' + region_id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // Clear existing departments
                $('#departementnaiss_id').empty();

                // Add default placeholder
                $('#departementnaiss_id').append('<option value="">Sélectionner un département</option>');

                // Populate department options
                data.forEach(function(departement) {
                    $('#departementnaiss_id').append('<option value="' + departement.id + '">' + departement.libelle + '</option>');
                });
            }
        });
    });
</script>



     <div class="form-group flex">
        <div class="flex-1 pr-2">
            <label for="situationmatrimoniale"><i class="fas fa-ring"style="color:#00626D;"></i></label>

            <select name="situationmatrimoniale" id="situationmatrimoniale" class="form-select">
                    <option value="Célibataire" {{ $userdata->situationmatrimoniale == 'Célibataire' ? 'selected' : '' }}>Célibataire</option>
                    <option value="Marié(e)" {{ $userdata->situationmatrimoniale == 'Marié(e)' ? 'selected' : '' }}>Marié(e)</option>
                    <option value="Divorcé(e)" {{ $userdata->situationmatrimoniale == 'Divorcé(e)' ? 'selected' : '' }}>Divorcé(e)</option>
                    <option value="Veuf/Veuve" {{ $userdata->situationmatrimoniale == 'Veuf/Veuve' ? 'selected' : '' }}>Veuf/Veuve</option>

                </select>
        </div>

        <div class="flex-1 pl-2">
            <label for="nombreenfant"><i class="fas fa-child"style="color:#00626D;"></i></label>
                 <input type="number" class="form-control" id="nombreenfant" name="nombreenfant" value="{{ $userdata->nombreenfant }}" required>

        </div>
            </div>
            <div class="form-group">


        </label>
     <br>
     <div class="form-group flex">

        <div class="form-group">
    <label for="lieuresidence">Lieu de Résidence</label>
    <select class="form-control" id="lieuresidence" name="lieuresidence" required>
        <option value="Sénégal" {{ old('lieuresidence', $userdata->lieuresidence) == 'Sénégal' ? 'selected' : '' }}>Sénégal</option>
        <option value="Diaspora" {{ old('lieuresidence', $userdata->lieuresidence) == 'Diaspora' ? 'selected' : '' }}>Diaspora</option>
    </select> </div>
        </div>


        <div class="form-group flex">
    <!-- Région de Résidence -->
    <div class="flex-1 pr-2" id="region-container">
        <label for="regionresidence_id">Région de Résidence</label>
        <select name="regionresidence_id" id="regionresidence_id" class="form-select" required>
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



<!-- Sélection des régions -->









    </div>




 <!-- Champ handicap supplémentaire qui s'affiche uniquement si "Oui" est sélectionné -->
 <div class="form-group">
                <label for="handicap_id">Handicap (Optionnel)</label>
                <select name="handicap_id" id="handicap_id" class="form-control shadow-sm">
        <option value="">Sélectionner un handicap (Optionnel)</option>
        @foreach($handicap as $handicap)
            <option value="{{ $handicap->id }}"
                {{ old('handicap_id', $userdata->handicap_id) == $handicap->id ? 'selected' : '' }}>
                {{ $handicap->libelle }}
            </option>
        @endforeach
    </select>
            </div>
    <div class="form-group flex justify-start mt-4">
        <button type="button" class="next-step flex items-center" id = "suivant">
            <span>Suivant</span>
            <i class="fas fa-arrow-right ml-2"></i> <!-- Arrow icon (left) -->
        </button>
    </div>
    </div>

     <!-- form fields -->


     </fieldset>










    <!-- Step 2: Professional Experience -->
    <div class="form-step" id="step-2" style="display: none;">
    <fieldset>
    <legend><h3>Étape 2 : Formation</h3></legend>


    <div class="form-group flex">
 <div class="flex-1 pr-2">
        <label for="academic_id"><i class="fas fa-graduation-cap" style="color:#00626D;"></i>Niveau formation</label>
        <select name="academic_id" id="academic_id" class="form-select" required>
                    @foreach($academins as $academic)
                        <option value="{{ $academic->id }}" {{ $academic->id == $userdata->academic_id ? 'selected' : '' }}>
                            {{ $academic->libelle }}
                        </option>
                    @endforeach
                </select></div>
    <div class="flex-1 pr-2">
        <label for="diplome"><i class="fas fa-graduation-cap" style="color:#00626D;"></i>Diplome</label>
        <input type="text" class="form-control" id="diplome" name="diplome" value="{{ $userdata->diplome }}">
        </div>

</div>

<div class="form-group flex">
    <div class="flex-1 pr-2">
        <label for="anneediplome"><i class="fas fa-calendar-check" style="color:#00626D;"></i>Année d'obstension</label>
        <input type="number" class="form-control" id="anneediplome" name="anneediplome" value="{{ $userdata->anneediplome }}">
            </div>

<div class="flex-1 pr-2">
        <label for="specialite"><i class="fas fa-cogs" style="color:#00626D;"></i> Spécialité</label>
        <input type="text" class="form-control" id="specialite" name="specialite" value="{{ $userdata->specialite }}">

          </div>
</div>
<div class="form-group flex">

    <div class="flex-1 pl-2">
        <label for="etablissementdiplome"><i class="fas fa-school" style="color:#00626D;"></i> Institution</label>
        <input type="text" class="form-control" id="etablissementdiplome" name="etablissementdiplome" value="{{ $userdata->etablissementdiplome }}">

           </div>
    <div class="flex-1 pl-2">
        <label for="autresdiplomes"><i class="fas fa-cogs" style="color:#00626D;"></i>Autre diplôme </label>
        <input type="text" class="form-control" id="autresdiplomes" name="autresdiplomes" value="{{ $userdata->autresdiplomes }}">

        </div>
</div>







    <div class="form-group flex justify-start mt-4">
        <button type="button"  id="prev" class="prev-step">

            <i class="fas fa-arrow-left"> </i>
            <span>Précédent</span>
        </button>



        <button type="button" class="next-step flex items-center" id = "suivant">
            <span>Suivant</span>
            <i class="fas fa-arrow-right ml-2"></i> <!-- Arrow icon (left) -->
        </button>

    </div>
</fieldset>







    </div>
    <!-- Step 3: Formation -->
    <div class="form-step" id="step-3" style="display: none;">
    <fieldset>
    <legend><h3>Étape 3 : Expérience profetionnelle</h3></legend>

    <div id="experience-container">
    <div class="form-group experience-item" style="display: flex; gap: 20px;">
    <div style="flex: 1;" class="form-group mt-3">
            <label for="experiences" style="display: inline-block; margin-right: 10px;">
                Expérience professionnelle <i class="fas fa-briefcase" style="color:#00626D;"></i>
            </label>
            <input type="text" class="form-control" id="experiences" name="experiences" value="{{ $userdata->experiences }}">
        </div>

        <div style="flex: 1;">
            <label for="nombreanneeexpe" style="display: inline-block; margin-right: 10px;">
                <i class="fas fa-cogs" style="color:#00626D;"></i>Nombre d'années d'expérience"
            </label>
            <input type="number" class="form-control" id="nombreanneeexpe" name="nombreanneeexpe" value="{{ $userdata->nombreanneeexpe }}">

                </div>
    </div>

    <div class="form-group experience-item" style="display: flex; gap: 20px;">
        <div style="flex: 1;">
            <label for="posteoccupe" style="display: inline-block; margin-right: 10px;">
                <i class="fas fa-briefcase" style="color:#00626D;"></i>Poste occupé
            </label>
            <input type="text" class="form-control" id="posteoccupe" name="posteoccupe" value="{{ $userdata->posteoccupe }}">

             </div>

        <div style="flex: 1;">
            <label for="employeur" style="display: inline-block; margin-right: 10px;">
                <i class="fas fa-building" style="color:#00626D;"></i>Employeur
            </label>
            <input type="text" class="form-control" id="employeur" name="employeur" value="{{ $userdata->employeur }}">

                 </div>
    </div>

    <div class="form-group experience-item">
         </div>
</div>


<!-- Bouton Ajouter une nouvelle expérience -->
<p type="button" id="add-experience" class="add-experience-btn flex items-center mt-4">
    <i class="fas fa-plus mr-2"></i> Ajouter une expérience
</p>



    <div class="form-group flex justify-start mt-4">
        <!-- Précédent button with left arrow -->
        <button type="button"  id="prev" class="prev-step">
            <i class="fas fa-arrow-left"></i>
            <span>Précédent</span>
        </button>

        <!-- Suivant button with right arrow -->


        <button type="button" class="next-step flex items-center" id = "suivant">
            <span>Suivant</span>
            <i class="fas fa-arrow-right ml-2"></i> <!-- Arrow icon (left) -->
        </button>
    </div>
</fieldset>



    </div>

    <!-- Step 4: Emploi -->
    <div class="form-step" id="step-4" style="display: none;">
    <fieldset>
        <legend><h3>Étape 4 : Emploi</h3></legend>

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
    <div class="form-group">
            <label for="motivation"><i class="fas fa-file-alt" style="color:#00626D;"></i> Lettre de motivation</label>
            <textarea id="motivation" class="form-control" name="motivation" placeholder="Lettre de motivation" required>{{ $userdata->motivation }}</textarea>
        </div>
<!-- SECTEUR 1 -->




        <div class="button-container">
    <!-- Bouton Précédent -->
    <button type="button" style="background-color:gray;" id="prev" class="prev-step">
        <i class="fa fa-arrow-left"></i> Précédent
    </button>

    <!-- Bouton Soumettre -->
    <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Soumettre</button>
        </div>
    </form>








</div>
 </fieldset>
    </div>


<!-- Vérifier si le numéro est passé dans la session -->



<!-- Popup -->





<script>
    document.getElementById("add-experience").addEventListener("click", function () {
        const container = document.getElementById("experience-container");
        const index = container.getElementsByClassName("experience-item").length + 1;

        const newExperience = document.createElement("div");
        newExperience.classList.add("form-group", "experience-item");
        newExperience.innerHTML = `
            <div style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label for="experiences_${index}" style="display: inline-block; margin-right: 10px;">
                        <i class="fas fa-briefcase" style="color:#00626D;"></i> Expérience professionnelle
                    </label>
                    <textarea id="experiences_${index}" name="experiences" required></textarea>
                </div>

                <div style="flex: 1;">
                    <label for="nombreanneeexpe_${index}" style="display: inline-block; margin-right: 10px;">
                        <i class="fas fa-cogs" style="color:#00626D;"></i> Nombre d'années d'expérience
                    </label>
                    <input type="number" id="nombreanneeexpe_${index}" name="nombreanneeexpe" required>
                </div>
            </div>

            <div style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label for="posteoccupe_${index}" style="display: inline-block; margin-right: 10px;">
                        <i class="fas fa-briefcase" style="color:#00626D;"></i> Poste occupé
                    </label>
                    <input type="text" id="posteoccupe_${index}" name="posteoccupe" required>
                </div>

                <div style="flex: 1;">
                    <label for="employeur_${index}" style="display: inline-block; margin-right: 10px;">
                        <i class="fas fa-building" style="color:#00626D;"></i> Employeur
                    </label>
                    <input type="text" id="employeur_${index}" name="employeur" required>
                </div>
            </div>



            <button type="button" class="remove-experience text-red-500 mt-2">Supprimer</button>
        `;

        container.appendChild(newExperience);

        // Ajouter un événement pour supprimer une expérience
        newExperience.querySelector(".remove-experience").addEventListener("click", function () {
            container.removeChild(newExperience);
        });
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


.id-card-photo img {
    width: 180px; /* Taille fixe pour la photo */
    height: 180px; /* Hauteur égale à la largeur */
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









@endsection




