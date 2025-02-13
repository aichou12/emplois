<div class="container">
    <h1 class="text-center mb-5">Formulaire Userdata</h1>

    <form action="{{ route('userdata.store') }}" method="POST" class="form-container" id="multi-step-form">
        @csrf

        <!-- Indicateur d'étapes -->
        <div class="step-indicator">
            <div class="step" id="step-indicator-1">1</div>
            <div class="step" id="step-indicator-2">2</div>
            <div class="step" id="step-indicator-3">3</div>
            <div class="step" id="step-indicator-4">4</div>
        </div>

        <!-- Étape 1: Informations personnelles -->
        <div class="form-step" id="step-1">

            <h2>Étape 1:Informations personnelles</h2>

            <div class="form-row">
    <div class="form-group " >
        <label for="utilisateur_id">Utilisateur</label>
        <select name="utilisateur_id" id="utilisateur_id" class="form-control shadow-sm">
            @foreach($utilisateurs as $utilisateur)
                <option value="{{ $utilisateur->id }}">{{ $utilisateur->firstname }}</option>
            @endforeach
        </select>

    </div>

    <div class="form-group">
        <label for="datenaiss">Date de Naissance</label>
        <input type="date" name="datenaiss" id="datenaiss" class="form-control shadow-sm" required>
    </div>
</div>

            <div class="form-group">
                <label for="regionnaiss_id">Région de Naissance</label>
                <select name="regionnaiss_id" id="regionnaiss_id" class="form-control">
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->libelle }}</option>
                    @endforeach
                </select>
            </div>




            <div class="form-group">
                    <label for="departementnaiss_id">Département de Naissance</label>
                    <select name="departementnaiss_id" id="departementnaiss_id" class="form-control">
                        @foreach($departements as $departement)
                            <option value="{{ $departement->id }}">{{ $departement->libelle }}</option>
                        @endforeach
                    </select>
           </div>
            <div class="form-group">
                <label for="lieuresidence">Lieu de Résidence</label>
                <input type="text" name="lieuresidence" id="lieuresidence" class="form-control shadow-sm" required>
            </div>
            <div class="form-group">
                    <label for="regionresidence_id">Région de Résidence</label>
                    <select name="regionresidence_id" id="regionresidence_id" class="form-control">
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->libelle }}</option>
                        @endforeach
                    </select>
            <div class="form-group">
                <label for="departementresidence_id">Département de Résidence</label>
                <select name="departementresidence_id" id="departementresidence_id" class="form-control">
                    @foreach($departements as $departement)
                        <option value="{{ $departement->id }}">{{ $departement->libelle }}</option>
                    @endforeach
                </select>
          </div>
            <div class="form-group">
                <label for="lieunaiss">Lieu de Naissance</label>
                <input type="text" name="lieunaiss" id="lieunaiss" class="form-control shadow-sm" required>
            </div>

            <div class="form-group">
                <label for="genre">Sexe</label>
                <select name="genre" id="genre" class="form-control shadow-sm" required>
                    <option value="masculin">Masculin</option>
                    <option value="feminin">Féminin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="telephone1">Téléphone 1</label>
                <input type="text" name="telephone1" id="telephone1" class="form-control shadow-sm" required>
            </div>

            <div class="form-group">
                <label for="telephone2">Téléphone 2</label>
                <input type="text" name="telephone2" id="telephone2" class="form-control shadow-sm">
            </div>
        <div class="form-group">
            <label for="situationmatrimoniale">Situation Matrimoniale</label>
            <select name="situationmatrimoniale" id="situationmatrimoniale" class="form-control shadow-sm" required>
    <option value="Célibataire">Célibataire</option>
    <option value="Marié(e)">Marié(e)</option>
    <option value="Veuf(ve)">Veuf(ve)</option>
</select>

                  </div>
                  <div class="form-group">
                <label for="nombreenfants">Nombre d'enfants</label>
                <input type="number" name="nombreenfants" id="nombreenfants" class="form-control shadow-sm">
            </div>
            <div class="form-group">
                <label for="handicap_id">Handicap (Optionnel)</label>
                <select name="handicap_id" id="handicap_id" class="form-control shadow-sm">
                    <option value="">Sélectionner un handicap</option>
                    @foreach($handicaps as $handicap)
                        <option value="{{ $handicap->id }}">{{ $handicap->libelle }}</option>
                    @endforeach
                </select>
            </div>
            </div>
            </div>
            </fieldset>
        <!-- Étape 2: Emploi et Handicap -->
        <div class="form-step" id="step-2" style="display: none;">


            <h2>Étape 2 : Formation </h2>

<div class="form-group">
    <label for="academic_id">Niveau de formation</label>
    <select name="academic_id" id="academic_id" class="form-control shadow-sm">
        @foreach($academins as $academin)
            <option value="{{ $academin->id }}">{{ $academin->libelle }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="diplome">Diplôme</label>
    <input type="text" name="diplome" id="diplome" class="form-control shadow-sm">
</div>

<div class="form-group">
    <label for="anneediplome">Année de Diplôme</label>
    <input type="number" name="anneediplome" id="anneediplome" class="form-control shadow-sm">
</div>

<div class="form-group">
<label for="specialite">Spécialité</label>
<input type="text" name="specialite" id="specialite" class="form-control">
</div>

<!-- Établissement du diplôme -->
<div class="form-group">
<label for="etablissementdiplome">Établissement du Diplôme</label>
<input type="text" name="etablissementdiplome" id="etablissementdiplome" class="form-control">
</div>
<div class="form-group">
            <label for="autresdiplomes">Autres Diplômes</label>
            <input type="text" name="autresdiplomes" id="autresdiplomes" class="form-control">
        </div>


        </div>

        <!-- Étape 3: Diplômes et Expériences -->
        <div class="form-step" id="step-3" style="display: none;">
        <h2>Étape 3:Expérience professionnelle</h2>
            <div class="form-group">
                <label for="experiences">Expériences</label>
                <textarea name="experiences" id="experiences" class="form-control shadow-sm"></textarea>
            </div>
            <div class="form-group">
    <label for="nombreanneeexpe">Nombre d'années d'expérience</label>
    <input type="number" name="nombreanneeexpe" id="nombreanneeexpe" class="form-control shadow-sm">
</div>

<div class="form-group">
    <label for="posteoccupe">Poste Occupé</label>
    <input type="text" name="posteoccupe" id="posteoccupe" class="form-control shadow-sm">
</div>

<div class="form-group">
    <label for="employeur">Employeur</label>
    <input type="text" name="employeur" id="employeur" class="form-control shadow-sm">
</div>
        </div>




        <!-- Étape 4: Soumettre le formulaire -->
        <div class="form-step" id="step-4" style="display: none;">
            <h2>Étape 4 : Emploi</h2>

            <div class="form-group">
                <label for="emploi1_id">Emploi 1</label>
                <select name="emploi1_id" id="emploi1_id" class="form-control shadow-sm">
                    @foreach($emplois as $emploi)
                        <option value="{{ $emploi->id }}">{{ $emploi->libelle }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
            <label for="anneeexperience1">Nombre d'années d'expérience sur l'emploi sollicité:</label>
            <input type="number" name="anneeexperience1" id="anneeexperience1" class="form-control">
        </div>
            <div class="form-group">
                <label for="emploi2_id">Emploi 2 (Optionnel)</label>
                <select name="emploi2_id" id="emploi2_id" class="form-control shadow-sm">
                    <option value="">Sélectionner un emploi</option>
                    @foreach($emplois as $emploi)
                        <option value="{{ $emploi->id }}">{{ $emploi->libelle }}</option>
                    @endforeach
                </select>
            </div>

        <div class="form-group">
            <label for="anneeexperience2">Nombre d'années d'expérience sur l'emploi sollicité:</label>
            <input type="number" name="anneeexperience2" id="anneeexperience2" class="form-control">
        </div>

            <button type="submit" class="btn btn-primary w-100 shadow-sm">Soumettre</button>
        </div>

        <!-- Navigation -->
        <div class="form-navigation">
            <button type="button" id="prev-button" class="btn btn-secondary" style="display: none;">Précédent</button>
            <button type="button" id="next-button" class="btn btn-primary">Suivant</button>
        </div>
    </form>
</div>

<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 30px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 2.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 30px;
    }

    .form-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-step {
        display: none;
    }

    .form-step:first-child {
        display: block;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-size: 1.1rem;
        font-weight: 500;
        margin-bottom: 10px;
        color: #555;
    }

    select, input, textarea {
        width: 100%;
        padding: 12px;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f7f7f7;
        transition: all 0.3s ease;
    }

    select:focus, input:focus, textarea:focus {
        border-color: #007bff;
        outline: none;
        background-color: #fff;
    }

    .step-indicator {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
    }

    .step {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        background-color: #ddd;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-weight: bold;
        font-size: 1rem;
    }

    .step.active {
        background-color: #007bff;
    }

    .step.completed {
        background-color: #28a745;
    }

    button {
        font-size: 1.1rem;
        padding: 12px;
        background-color: #007bff;
        border: none;
        color: white;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    button:hover {
        background-color: #0056b3;
    }
</style>

<script>
    let currentStep = 1;
const totalSteps = 4;

const stepIndicators = document.querySelectorAll('.step');
const prevButton = document.getElementById('prev-button');
const nextButton = document.getElementById('next-button');
const steps = document.querySelectorAll('.form-step');

function showStep(step) {
    steps.forEach((stepElement, index) => {
        stepElement.style.display = (index + 1 === step) ? 'block' : 'none';
    });

    stepIndicators.forEach((indicator, index) => {
        indicator.classList.remove('active', 'completed');
        if (index + 1 === step) {
            indicator.classList.add('active');
        } else if (index + 1 < step) {
            indicator.classList.add('completed');
        }
    });

    prevButton.style.display = (step === 1) ? 'none' : 'inline-block';

}

prevButton.addEventListener('click', () => {
    if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
    }
});

nextButton.addEventListener('click', () => {
    if (currentStep < totalSteps) {
        currentStep++;
        showStep(currentStep);
    } else {
        document.getElementById('multi-step-form').submit();
    }
});

showStep(currentStep);

</script>
