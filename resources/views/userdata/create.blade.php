@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/pgde-form.css') }}">
<script src="https://cdn.tailwindcss.com"></script>

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

@if ($errors->any())
  <div class="alert alert-danger mb-4 shadow-sm" role="alert">
    <strong>Veuillez corriger les erreurs suivantes :</strong>
    <ul class="mb-0 ps-3">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
  </div>
@endif

<form id="userdata-create-form" class="pgde-create-form" action="{{ route('userdata.store') }}" data-draft-url="{{ route('userdata.draft-step') }}" method="POST" enctype="multipart/form-data" novalidate>
    @csrf
    <p id="create-submit-message" class="pgde-submit-message" role="alert" hidden>Veuillez vérifier les champs signalés et compléter les champs obligatoires.</p>

    @include('userdata.partials.create-personal')
    @include('userdata.partials.create-formation')
    @include('userdata.partials.create-experience')
    @include('userdata.partials.create-employment')
</form>

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
    const savedDraft = @json($draft?->payload ?? []);
    const savedFiles = @json($draft?->files ?? []);
    let currentStep = {{ $draft?->current_step ?? 1 }};
    const steps = document.querySelectorAll('.form-step');
    const indicators = Array.from(document.querySelectorAll('.step-indicator'));       // Toutes les étapes
    const nextButtons = document.querySelectorAll('.next-step'); // Boutons "Suivant"
    const prevButtons = document.querySelectorAll('.prev-step'); // Boutons "Précédent"
    const totalSteps = steps.length;                             // Nombre total d’étapes
    const form = document.getElementById('userdata-create-form');
    const submitButton = form.querySelector('.btn-submit-step');
    const submitMessage = document.getElementById('create-submit-message');
    const fieldErrorElements = new WeakMap();

    function fieldValidationMessage(field) {
        if (field.validity.valueMissing) return 'Ce champ est obligatoire.';
        if (field.validity.rangeOverflow && field.name.includes('[anneediplome]')) return `L’année d’obtention ne peut pas dépasser ${field.max}.`;
        if (field.validity.rangeUnderflow && field.name.includes('[anneediplome]')) return `L’année d’obtention doit être au moins égale à ${field.min}.`;
        if (field.validity.rangeUnderflow && field.name.includes('[years]')) return 'Le nombre d’années d’expérience ne peut pas être négatif.';
        if (field.validity.rangeOverflow && field.name.includes('[years]')) return `Le nombre d’années d’expérience ne peut pas dépasser ${field.max} ans.`;
        if (field.validity.rangeOverflow) return `La valeur doit être inférieure ou égale à ${field.max}.`;
        if (field.validity.rangeUnderflow) return `La valeur doit être supérieure ou égale à ${field.min}.`;
        if (field.validity.typeMismatch) return 'Le format saisi n’est pas valide.';
        if (field.validity.patternMismatch) return 'Le format saisi n’est pas valide.';
        if (field.validity.badInput) return 'Veuillez saisir une valeur valide.';
        return 'Veuillez vérifier cette valeur.';
    }

    function displayFieldError(field) {
        let message = fieldErrorElements.get(field);
        if (!message) {
            message = document.createElement('small');
            message.className = 'js-field-validation-error';
            message.setAttribute('role', 'alert');
            field.insertAdjacentElement('afterend', message);
            fieldErrorElements.set(field, message);
        }
        message.textContent = fieldValidationMessage(field);
        field.classList.add('border-danger');
        field.setAttribute('aria-invalid', 'true');
    }

    function clearFieldError(field) {
        fieldErrorElements.get(field)?.remove();
        fieldErrorElements.delete(field);
        field.classList.remove('border-danger');
        field.removeAttribute('aria-invalid');
    }

    function firstInvalidField() {
        return Array.from(form.elements).find(field =>
            field.willValidate && !field.checkValidity()
        );
    }

    function updateSubmitButton() {
        const hasInvalidField = Boolean(firstInvalidField());
        submitButton.setAttribute('aria-disabled', String(hasInvalidField));
        if (!hasInvalidField) {
            submitMessage.hidden = true;
        }
    }

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

    function valueAtPath(object, name) {
        const parts = name.replace(/\]/g, '').split('[');
        return parts.reduce((value, part) => value == null ? undefined : value[part], object);
    }

    async function restoreDraft() {
        const formations = savedDraft.formations || [];
        const experiences = savedDraft.experiences || [];
        const formationContainer = document.getElementById('formation-container');
        const experienceContainer = document.getElementById('experience-container');
        for (let i = formationContainer.querySelectorAll('.formation-item').length; i < formations.length; i++) document.getElementById('add-formation').click();
        if (savedDraft.hasExperience === 'oui') {
            const selector = document.querySelector('input[name="hasExperience"][value="oui"]');
            if (selector) {
                selector.checked = true;
                selector.dispatchEvent(new Event('change', { bubbles: true }));
            }
            for (let i = experienceContainer.querySelectorAll('.experience-item').length; i < experiences.length; i++) document.getElementById('add-experience').click();
        } else if (savedDraft.hasExperience === 'non') {
            const selector = document.querySelector('input[name="hasExperience"][value="non"]');
            if (selector) selector.checked = true;
        }

        for (const field of form.elements) {
            if (!field.name || field.type === 'file' || field.name === 'utilisateur_id') continue;
            const value = valueAtPath(savedDraft, field.name);
            if (value === undefined || value === null) continue;
            if (field.type === 'radio' || field.type === 'checkbox') field.checked = String(value) === field.value;
            else if (field.tagName === 'SELECT' && field.name === 'departementnaiss_id') continue;
            else if (field.tagName === 'SELECT' && field.name === 'departementresidence_id') continue;
            else field.value = value;
        }

        if (savedDraft.is_abroad !== undefined) document.getElementById('is_abroad')?.dispatchEvent(new Event('change', { bubbles: true }));
        if (typeof toggleHandicapField === 'function') toggleHandicapField();
        document.querySelectorAll('.formation-item').forEach(block => block.querySelector('.academic-select')?.dispatchEvent(new Event('change')));

        for (const [regionId, departmentId] of [['regionnaiss_id','departementnaiss_id'], ['regionresidence_id','departementresidence_id']]) {
            const region = document.getElementById(regionId)?.value;
            const selectedDepartment = savedDraft[departmentId];
            if (region && selectedDepartment) {
                const response = await fetch(`/departements/${region}`);
                const departments = await response.json();
                const select = document.getElementById(departmentId);
                select.innerHTML = '<option value="">-- Département --</option>';
                departments.forEach(item => select.add(new Option(item.libelle, item.id)));
                select.value = selectedDepartment;
            }
        }

        for (const [sectorId, jobId] of [['secteur1_id','emploi1_id'], ['secteur2_id','emploi2_id']]) {
            const sector = document.getElementById(sectorId)?.value;
            if (sector && savedDraft[jobId]) {
                const response = await fetch(`/emplois-par-secteur/${sector}`);
                const jobs = await response.json();
                const select = document.getElementById(jobId);
                select.innerHTML = '<option value="">-- Choisir un emploi --</option>';
                jobs.forEach(item => select.add(new Option(item.libelle, item.id)));
                select.value = savedDraft[jobId];
            }
        }
        if (Object.keys(savedFiles).length) {
            const note = document.createElement('p');
            note.className = 'pgde-submit-message';
            note.textContent = 'Les fichiers déjà joints sont conservés dans votre brouillon.';
            form.prepend(note);
        }
        updateSubmitButton();
    }

    async function saveCurrentStep() {
        const data = new FormData();
        data.append('_token', form.querySelector('[name="_token"]').value);
        data.append('step', currentStep);
        const activeStep = steps[currentStep - 1];
        for (const field of activeStep.querySelectorAll('input, select, textarea')) {
            if (!field.name || field.name === 'utilisateur_id' || field.disabled) continue;
            if (field.type === 'file') {
                Array.from(field.files || []).forEach(file => data.append(field.name, file));
            } else if ((field.type !== 'radio' && field.type !== 'checkbox') || field.checked) {
                data.append(field.name, field.value);
            }
        }
        const button = activeStep.querySelector('.next-step');
        const label = button?.innerHTML;
        if (button) { button.disabled = true; button.textContent = 'Enregistrement…'; }
        try {
            const response = await fetch(form.dataset.draftUrl, { method: 'POST', body: data, headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
            const result = await response.json();
            if (!response.ok) throw new Error(Object.values(result.errors || {}).flat()[0] || result.message || 'La sauvegarde a échoué.');
            return true;
        } catch (error) {
            alert(error.message);
            return false;
        } finally {
            if (button) { button.disabled = false; button.innerHTML = label; }
        }
    }

    // Vérifie si tous les champs [required] de l’étape courante sont remplis
    // Renvoie true s'ils sont tous remplis, false sinon.
    function checkRequiredFields(stepIndex) {
        const currentStepDiv = steps[stepIndex - 1];
        const fields = Array.from(currentStepDiv.querySelectorAll('input, select, textarea'))
            .filter(field => field.willValidate);
        const invalidFields = fields.filter(field => !field.checkValidity());
        fields.filter(field => field.checkValidity()).forEach(clearFieldError);
        invalidFields.forEach(displayFieldError);
        if (invalidFields.length) {
            invalidFields[0].focus({ preventScroll: true });
            invalidFields[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }
        return true;
    }

    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => { if (index + 1 <= currentStep) showStep(index + 1); });
    });

    // Afficher la première étape dès le chargement
    restoreDraft().then(() => showStep(currentStep));
    updateSubmitButton();

    function handleFieldChange(event) {
        updateSubmitButton();
        const field = event.target;
        if (!fieldErrorElements.has(field)) return;
        if (field.checkValidity()) clearFieldError(field);
        else displayFieldError(field);
    }
    form.addEventListener('input', handleFieldChange);
    form.addEventListener('change', handleFieldChange);
    new MutationObserver(updateSubmitButton).observe(form, {
        attributes: true,
        attributeFilter: ['required'],
        childList: true,
        subtree: true
    });
    let isSubmitting = false;
    form.addEventListener('submit', async event => {
        event.preventDefault();
        if (isSubmitting) return;
        const invalidField = firstInvalidField();
        if (invalidField) {
            event.preventDefault();
            submitMessage.hidden = false;
            const invalidStep = invalidField.closest('.form-step');
            if (invalidStep) {
                const invalidStepNumber = Array.from(steps).indexOf(invalidStep) + 1;
                showStep(invalidStepNumber);
                checkRequiredFields(invalidStepNumber);
            }
            invalidField.focus();
            return;
        }

        isSubmitting = true;
        submitButton.disabled = true;
        if (!await saveCurrentStep()) {
            isSubmitting = false;
            submitButton.disabled = false;
            return;
        }
        form.querySelectorAll('input[type="file"]').forEach(field => { field.disabled = true; });
        HTMLFormElement.prototype.submit.call(form);
    });

    // Bouton “Suivant”
    nextButtons.forEach(btn => {
        btn.addEventListener('click', async () => {
            // 1) Vérifier les champs obligatoires de l’étape actuelle
            if (!checkRequiredFields(currentStep)) {
                return; // On bloque la navigation
            }
            // 2) Si tous les champs sont remplis, on passe à l’étape suivante
            if (currentStep < totalSteps && await saveCurrentStep()) {
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
.pgde-create-form .btn-submit-step[aria-disabled="true"] { background:#aeb7b1 !important; color:#fff !important; box-shadow:none; cursor:not-allowed; opacity:.75; }
.pgde-submit-message { margin:0 0 12px; color:#8a4b08; font-size:14px; }
.pgde-create-form .js-field-validation-error { display:block; margin-top:4px; color:#a12622; font-size:12px; }
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
