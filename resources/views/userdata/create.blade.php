<div class="container">
    <h1 class="text-center mb-5">Formulaire Userdata</h1>
    <div class="form-group">
    <label for="utilisateur_id">Bonjour {{ $utilisateurConnecte->firstname }} {{ $utilisateurConnecte->lastname }} </label>
    
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
    <!-- Exemple dans le formulaire de création (create.blade.php) -->


            <h2>Étape 1:Informations personnelles</h2>
            <div class="form-grid">
    <div class="form-group">
        <label for="utilisateur_id">Nom</label>
        <input type="text" name="utilisateur_id' class="form-control" id="utilisateur_id" value=
        "{{ $utilisateurConnecte->firstname }} "
         readonly>

    </div>
    <div class="form-group">
        <label for="utilisateur_id">Prenom</label>
        <input type="text" name="utilisateur_id' class="form-control" id="utilisateur_id" value=
        " {{ $utilisateurConnecte->lastname }}"
         readonly>
    </div>
  
    <div class="form-group">
        <label for="utilisateur_id">CNI</label>
        <input type="text" name="utilisateur_id' class="form-control" id="utilisateur_id" value=
        "{{ $utilisateurConnecte->numberid }} "
         readonly> </div>
        
            <div class="form-group">
        <label for="datenaiss">Date de Naissance</label>
        <input type="date" name="datenaiss" id="datenaiss" class="form-control shadow-sm" required>
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
            <div>
            <label for="situationmatrimoniale">Situation matrimoniale</label>
            <select id="situationmatrimoniale" name="situationmatrimoniale" required>
                <option value="Célibataire">Célibataire</option>
                <option value="Marié(e)">Marié(e)</option>
                <option value="Divorcé(e)">Divorcé(e)</option>
                <option value="Veuf/Veuve">Veuf/Veuve</option>
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
        padding: 40px;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 30px;
        text-align: center;
    }

    .form-container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .form-step {
        display: none;
        animation: fadeIn 0.5s ease-in-out;
    }

    .form-step:first-child {
        display: block;
    }

    .form-group {
        margin-bottom: 25px;
    }

    label {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #34495e;
        display: block;
    }

    select, input, textarea {
        width: 100%;
        padding: 12px;
        font-size: 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        background-color: #f9f9f9;
        transition: all 0.3s ease;
    }

    select:focus, input:focus, textarea:focus {
        border-color: #3498db;
        outline: none;
        background-color: #ffffff;
        box-shadow: 0 0 8px rgba(52, 152, 219, 0.3);
    }

    .step-indicator {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
    }

    .step {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #e0e0e0;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-weight: bold;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    .form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* Deux colonnes de largeur égale */
    gap: 20px; /* Espacement entre les champs */
    margin-bottom: 20px; /* Espacement entre les lignes */
}

/* Pour les petits écrans, on passe à une seule colonne */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
}
    .step.active {
        background-color: #3498db;
        transform: scale(1.1);
    }

    .step.completed {
        background-color: #2ecc71;
    }

    button {
        font-size: 1.1rem;
        padding: 12px 24px;
        background-color: #3498db;
        border: none;
        color: white;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    button:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
    }

    button:active {
        transform: translateY(0);
    }

    .form-navigation {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }

    .btn-secondary {
        background-color: #95a5a6;
    }

    .btn-secondary:hover {
        background-color: #7f8c8d;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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
            if (index + 1 === step) {
                stepElement.style.display = 'block';
                stepElement.style.animation = 'fadeIn 0.5s ease-in-out';
            } else {
                stepElement.style.display = 'none';
            }
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
        nextButton.textContent = (step === totalSteps) ? 'Soumettre' : 'Suivant';
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