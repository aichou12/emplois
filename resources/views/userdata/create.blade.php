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
   <link rel="stylesheet" href="{{ asset('css/pgde-form.css') }}">

   <script src="https://cdn.tailwindcss.com"></script>

</head>


</style>
@include('partials.user-header')

<div class="d-flex justify-content-end">
  <div class="dropdown">
    <a class="btn btn-light border dropdown-toggle" href="#" role="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
      <span class="underline-text">INSCRIPTION N°: {{ $utilisateurConnecte->id }}</span>
    </a>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <li><a class="dropdown-item" href="{{ route('logout') }}">Déconnexion</a></li>
    </ul>
  </div>
</div>
</br>


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

<nav class="pgde-progress" aria-label="Progression du formulaire">
  <button type="button" class="step-indicator" id="indicator-step-1" aria-label="Étape 1 : Informations personnelles"><span class="step-indicator__number">1</span><span class="step-indicator__label">Informations personnelles</span></button>
  <span class="step-indicator__line" aria-hidden="true"></span>
  <button type="button" class="step-indicator" id="indicator-step-2" aria-label="Étape 2 : Formation"><span class="step-indicator__number">2</span><span class="step-indicator__label">Formation</span></button>
  <span class="step-indicator__line" aria-hidden="true"></span>
  <button type="button" class="step-indicator" id="indicator-step-3" aria-label="Étape 3 : Expérience"><span class="step-indicator__number">3</span><span class="step-indicator__label">Expérience</span></button>
  <span class="step-indicator__line" aria-hidden="true"></span>
  <button type="button" class="step-indicator" id="indicator-step-4" aria-label="Étape 4 : Emploi"><span class="step-indicator__number">4</span><span class="step-indicator__label">Emploi</span></button>
</nav>

<form class="pgde-create-form" action="{{ route('userdata.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    @include('userdata.partials.create-personal')
    @include('userdata.partials.create-formation')
    @include('userdata.partials.create-experience')
    @include('userdata.partials.create-employment')
</form>

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

        <button type="button" class="remove-experience" style="background-color: #f56565; color: white; margin-top: 0.5rem; padding: 0.5rem 1rem; border-radius: 0.25rem;">
            Supprimer
        </button>


               `;

        container.appendChild(newExperience);

        // Ajouter un événement pour supprimer une expérience
        newExperience.querySelector(".remove-experience").addEventListener("click", function () {
            container.removeChild(newExperience);
        });
    });
</script>

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
    const steps = document.querySelectorAll('.form-step');
    const indicators = Array.from(document.querySelectorAll('.step-indicator'));       // Toutes les étapes
    const nextButtons = document.querySelectorAll('.next-step'); // Boutons "Suivant"
    const prevButtons = document.querySelectorAll('.prev-step'); // Boutons "Précédent"
    const totalSteps = steps.length;                             // Nombre total d’étapes

    // Affiche seulement l’étape “stepNumber” et masque les autres
    function showStep(stepNumber) {
        currentStep = Math.max(1, Math.min(stepNumber, totalSteps));
        steps.forEach((step, index) => {
            const active = index === currentStep - 1;
            step.style.display = active ? 'block' : 'none';
            step.classList.toggle('active', active);
        });
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentStep - 1);
            indicator.classList.toggle('completed', index < currentStep - 1);
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

    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => showStep(index + 1));
    });

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



<style>
.pgde-create-form fieldset { border: 1px solid var(--color-border); border-radius: var(--radius-md); background: var(--color-white); box-shadow: var(--shadow-card); padding: var(--space-4); }
.pgde-create-form .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: var(--space-2); }
.pgde-create-form .form-group label { display: flex; align-items: center; gap: 7px; font-size: 13px; font-weight: 500; color: var(--color-text-secondary); }
.pgde-create-form input:not([type="radio"]):not([type="checkbox"]), .pgde-create-form select, .pgde-create-form textarea { width: 100%; box-sizing: border-box; padding: 10px 12px; border: 1px solid var(--color-border); border-radius: var(--radius-sm); background: var(--color-white); color: var(--color-text); font: 14.5px var(--font-body); }
.pgde-create-form input:focus, .pgde-create-form select:focus, .pgde-create-form textarea:focus { outline: none; border-color: var(--color-primary); box-shadow: 0 0 0 3px rgba(0,140,69,.16); }
.pgde-create-form .pgde-action-buttons { display:flex; justify-content:space-between; align-items:center; gap:12px; margin-top:var(--space-4); padding-top:var(--space-2); border-top:1px solid var(--color-border); }
.pgde-create-form .pgde-action-buttons button { margin:0; }
.pgde-create-form .next-step, .pgde-create-form .btn-submit-step { background:linear-gradient(135deg,var(--color-primary),var(--color-primary-dark)) !important; color:#fff !important; border:0; border-radius:var(--radius-sm); padding:12px 26px; font:600 14.5px var(--font-body); box-shadow:0 3px 10px rgba(0,140,69,.28); }
.pgde-create-form .prev-step { background:#fff !important; color:var(--color-text-secondary) !important; border:1px solid var(--color-border); border-radius:var(--radius-sm); padding:11px 22px; font:500 14.5px var(--font-body); }
.pgde-create-form .prev-step:hover { border-color:var(--color-primary); color:var(--color-primary-dark) !important; }
.pgde-create-form .form-group.flex { flex-direction:row; align-items:flex-start; }
.pgde-progress .step-indicator { display:inline-flex; align-items:center; gap:10px; min-width:0; padding:6px 12px; border:0; background:transparent !important; color:var(--color-text-secondary) !important; cursor:pointer; font:500 .9rem var(--font-body); text-align:left; border-radius:var(--radius-sm); }
.pgde-progress .step-indicator:hover { background:var(--color-info-light) !important; color:var(--color-primary-dark) !important; }
.pgde-progress .step-indicator.active { color:var(--color-primary) !important; font-weight:600; background:rgba(0,140,69,.08) !important; }
.pgde-progress .step-indicator.completed { color:var(--color-primary-dark) !important; }
@media(max-width:768px) { .pgde-create-form .form-group.flex { flex-direction:column; gap:0; } }
.pgde-create-form #add-formation, .pgde-create-form #add-experience { background:linear-gradient(135deg,var(--color-primary),var(--color-primary-dark)) !important; border:0; border-radius:var(--radius-sm); color:#fff; padding:10px 18px; font:600 13.5px var(--font-body); }
.pgde-create-form .formation-item, .pgde-create-form .experience-item { border:1px solid var(--color-border); border-left:3px solid var(--color-primary); border-radius:var(--radius-md); background:var(--color-bg-subtle); padding:var(--space-3); margin-top:var(--space-2); }
@media(max-width:768px) { .pgde-create-form fieldset { padding:18px 14px; } .pgde-create-form .pgde-action-buttons { align-items:stretch; } .pgde-create-form .pgde-action-buttons button { flex:1; justify-content:center; } .pgde-create-form .flex.gap-5 { flex-direction:column; gap:0; } }
</style>
@endsection
