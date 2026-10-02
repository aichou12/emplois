    <!-- Step 3: Expérience professionnelle -->
    <div class="form-step" id="step-3" style="display:none;">
  <fieldset>
    <div class="pgde-step-intro">
      <div class="pgde-step-kicker">Étape 3 sur 4</div>
      <h2>Expérience professionnelle</h2>
      <p>Pour chaque expérience : le poste, l'entreprise, la durée, puis un court résumé de vos missions.</p>
    </div>

    <div class="form-group">
      <p class="mb-2">Avez-vous de l'expérience professionnelle ?</p>
      <div class="pgde-radio-group" role="radiogroup" aria-label="Expérience professionnelle">
        <label class="pgde-radio-option" for="hasExperienceOui">
          <input type="radio" id="hasExperienceOui" name="hasExperience" value="oui" required>
          <span>Oui</span>
        </label>
        <label class="pgde-radio-option" for="hasExperienceNon">
          <input type="radio" id="hasExperienceNon" name="hasExperience" value="non">
          <span>Non</span>
        </label>
      </div>
    </div>

    <div id="experience-wrapper" style="display:none;">
      <div id="experience-container" class="space-y-4">
        <!-- Bloc expérience initial (index 0) -->
        <div class="form-group experience-item" data-index="0">
          <!-- 1. Poste et entreprise -->
          <div class="pgde-grid-2">
            <div class="form-group mb-0">
              <label for="experiences_0_poste"><i class="fas fa-user-tie"></i> Poste occupé</label>
              <input type="text" id="experiences_0_poste" name="experiences[0][poste]" class="form-control" placeholder="Intitulé du poste, ex : Comptable" maxlength="150">
            </div>
            <div class="form-group mb-0">
              <label for="experiences_0_employeur"><i class="fas fa-building"></i> Entreprise ou employeur</label>
              <input type="text" id="experiences_0_employeur" name="experiences[0][employeur]" class="form-control" placeholder="Nom de la structure, ex : Sonatel" maxlength="150">
            </div>
          </div>

          <!-- 2. Durée -->
          <div class="pgde-grid-2 mt-3">
            <div class="form-group mb-0">
              <label for="experiences_0_years"><i class="fas fa-clock"></i> Durée (en années)</label>
              <input type="number" id="experiences_0_years" name="experiences[0][years]" class="form-control" placeholder="ex : 3" min="0" max="70">
            </div>
          </div>

          <!-- 3. Missions : texte court, limité -->
          <div class="form-group mb-0 mt-3">
            <label for="experiences_0_description"><i class="fas fa-list-check"></i> Missions principales</label>
            <textarea id="experiences_0_description" name="experiences[0][description]" class="form-control" rows="3" maxlength="500" data-char-counter placeholder="En 2 ou 3 phrases : vos tâches et réalisations principales"></textarea>
            <div class="pgde-field-foot">
              <span>Facultatif · 500 caractères maximum</span>
              <span class="pgde-char-count" aria-live="polite">0 / 500</span>
            </div>
          </div>

          <div class="mt-3 flex justify-end">
            <button type="button" class="btn-remove-item remove-experience" style="display:none;">
              <i class="fas fa-trash-alt"></i> Supprimer
            </button>
          </div>
        </div>
      </div>

      <!-- Le bouton reste TOUJOURS en bas -->
      <div id="add-experience-bar" class="mt-4">
        <button type="button" id="add-experience" class="btn-add-item">
          <i class="fas fa-plus mr-2"></i> Ajouter une expérience
        </button>
      </div>
    </div>

    <div class="pgde-action-buttons">
      <button type="button" class="prev-step"><i class="fas fa-arrow-left"></i> <span>Précédent</span></button>
      <button type="button" class="next-step flex items-center"><span>Suivant</span> <i class="fas fa-arrow-right ml-2"></i></button>
    </div>
  </fieldset>
</div>
<script>
(function(){
  const hasExpRadios = document.querySelectorAll('input[name="hasExperience"]');
  const wrapper = document.getElementById('experience-wrapper');
  const container = document.getElementById('experience-container');
  const addBtn = document.getElementById('add-experience');

  function tplExperience(i){
    return `
      <div class="form-group experience-item" data-index="${i}">
          <!-- 1. Poste et entreprise -->
          <div class="pgde-grid-2">
            <div class="form-group mb-0">
              <label for="experiences_${i}_poste"><i class="fas fa-user-tie"></i> Poste occupé</label>
              <input type="text" id="experiences_${i}_poste" name="experiences[${i}][poste]" class="form-control" placeholder="Intitulé du poste, ex : Comptable" maxlength="150">
            </div>
            <div class="form-group mb-0">
              <label for="experiences_${i}_employeur"><i class="fas fa-building"></i> Entreprise ou employeur</label>
              <input type="text" id="experiences_${i}_employeur" name="experiences[${i}][employeur]" class="form-control" placeholder="Nom de la structure, ex : Sonatel" maxlength="150">
            </div>
          </div>

          <!-- 2. Durée -->
          <div class="pgde-grid-2 mt-3">
            <div class="form-group mb-0">
              <label for="experiences_${i}_years"><i class="fas fa-clock"></i> Durée (en années)</label>
              <input type="number" id="experiences_${i}_years" name="experiences[${i}][years]" class="form-control" placeholder="ex : 3" min="0" max="70">
            </div>
          </div>

          <!-- 3. Missions : texte court, limité -->
          <div class="form-group mb-0 mt-3">
            <label for="experiences_${i}_description"><i class="fas fa-list-check"></i> Missions principales</label>
            <textarea id="experiences_${i}_description" name="experiences[${i}][description]" class="form-control" rows="3" maxlength="500" data-char-counter placeholder="En 2 ou 3 phrases : vos tâches et réalisations principales"></textarea>
            <div class="pgde-field-foot">
              <span>Facultatif · 500 caractères maximum</span>
              <span class="pgde-char-count" aria-live="polite">0 / 500</span>
            </div>
          </div>

          <div class="mt-3 flex justify-end">
            <button type="button" class="btn-remove-item remove-experience">
              <i class="fas fa-trash-alt"></i> Supprimer
            </button>
          </div>
        </div>`;
  }

  function addExperience(){
    const i = container.querySelectorAll('.experience-item').length;
    container.insertAdjacentHTML('beforeend', tplExperience(i));
  }

  // toggle affichage section expériences
  function toggleExperienceFields() {
    const selected = document.querySelector('input[name="hasExperience"]:checked');
    const show = selected?.value === 'oui';
    wrapper.style.display = show ? 'block' : 'none';
    if (!show){
      // Optionnel: vider le container (si l'utilisateur repasse à "non")
      // container.innerHTML = container.firstElementChild.outerHTML; // remet à 1 bloc
    }
  }
  hasExpRadios.forEach(radio => radio.addEventListener('change', toggleExperienceFields));

  // remove (delegation)
  container.addEventListener('click', (e) => {
    const removeButton = e.target.closest('.remove-experience');
    if (removeButton){
      const block = removeButton.closest('.experience-item');
      block.remove();
    }
  });

  addBtn.addEventListener('click', addExperience);

  // Compteur de caractères des missions
  container.addEventListener('input', (e) => {
    const field = e.target.closest('textarea[data-char-counter]');
    if (!field) return;
    const counter = field.parentElement.querySelector('.pgde-char-count');
    if (counter) counter.textContent = `${field.value.length} / ${field.maxLength}`;
  });
})();
</script>




