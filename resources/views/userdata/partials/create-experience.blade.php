<!-- Étape 3 : expérience professionnelle -->
<div class="form-step" id="step-3" style="display:none;">
  <fieldset>
    <div class="pgde-step-intro">
      <div class="pgde-step-kicker">Étape 3 sur 4</div>
      <h2>Expérience professionnelle</h2>
      <p>Stages, emplois, bénévolat : tout compte. Pas d'expérience ? Répondez simplement « Non ».</p>
    </div>

    <!-- Question d'entrée : grandes pastilles Oui / Non -->
    <div class="form-group">
      <span class="pgde-group-label" id="label-has-experience">Avez-vous déjà une expérience professionnelle ? <span class="pgde-req">*</span></span>
      <div class="pgde-chips pgde-chips-large" role="radiogroup" aria-labelledby="label-has-experience">
        <label class="pgde-chip" for="hasExperienceOui">
          <input type="radio" id="hasExperienceOui" name="hasExperience" value="oui" required>
          <i class="fas fa-briefcase" aria-hidden="true"></i> Oui, j'ai de l'expérience
        </label>
        <label class="pgde-chip" for="hasExperienceNon">
          <input type="radio" id="hasExperienceNon" name="hasExperience" value="non">
          <i class="fas fa-seedling" aria-hidden="true"></i> Non, pas encore
        </label>
      </div>
    </div>

    <p class="pgde-empty-note" id="experience-none-note" hidden>
      <i class="fas fa-circle-check" aria-hidden="true"></i> Pas de souci : cette étape est terminée, cliquez sur « Suivant ».
    </p>

    <div id="experience-wrapper" hidden>
      <div id="experience-container" class="pgde-item-list">
        <!-- Carte expérience n°1 -->
        <div class="experience-item pgde-item-card" data-index="0">
          <div class="pgde-item-head">
            <span class="pgde-item-badge"><i class="fas fa-briefcase" aria-hidden="true"></i> Expérience <span class="experience-item-num">1</span></span>
            <button type="button" class="btn-remove-item remove-experience" hidden><i class="fas fa-trash-can" aria-hidden="true"></i> Retirer</button>
          </div>

          <div class="pgde-grid-2">
            <div class="form-group">
              <label for="experiences_0_poste">Poste occupé</label>
              <input type="text" id="experiences_0_poste" name="experiences[0][poste]" class="form-control" placeholder="ex : Comptable" maxlength="150">
            </div>
            <div class="form-group">
              <label for="experiences_0_employeur">Entreprise ou employeur</label>
              <input type="text" id="experiences_0_employeur" name="experiences[0][employeur]" class="form-control" placeholder="ex : Sonatel" maxlength="150">
            </div>
          </div>

          <div class="form-group pgde-field-narrow">
            <label for="experiences_0_years">Durée (en années)</label>
            <input type="number" id="experiences_0_years" name="experiences[0][years]" class="form-control" placeholder="ex : 3" min="0" max="70" inputmode="numeric">
          </div>

          <div class="form-group">
            <label for="experiences_0_description">Missions principales <span class="pgde-optional">facultatif</span></label>
            <textarea id="experiences_0_description" name="experiences[0][description]" class="form-control" rows="3" maxlength="500" data-char-counter placeholder="En 2 ou 3 phrases : vos tâches et réalisations principales"></textarea>
            <div class="pgde-field-foot">
              <span>500 caractères maximum</span>
              <span class="pgde-char-count" aria-live="polite">0 / 500</span>
            </div>
          </div>
        </div>
      </div>

      <div id="add-experience-bar" class="pgde-add-bar">
        <button type="button" id="add-experience" class="pgde-add-button">
          <i class="fas fa-plus" aria-hidden="true"></i> Ajouter une autre expérience
        </button>
      </div>
    </div>

    <div class="pgde-action-buttons">
      <button type="button" class="prev-step"><i class="fas fa-arrow-left" aria-hidden="true"></i> <span>Précédent</span></button>
      <button type="button" class="next-step"><span>Suivant</span> <i class="fas fa-arrow-right" aria-hidden="true"></i></button>
    </div>
  </fieldset>
</div>

<script>
(function () {
  const wrapper = document.getElementById('experience-wrapper');
  const container = document.getElementById('experience-container');
  const addBtn = document.getElementById('add-experience');
  const noneNote = document.getElementById('experience-none-note');
  const firstCard = container.querySelector('.experience-item');
  const template = firstCard.cloneNode(true);

  // Oui : cartes visibles ; Non : message de confirmation
  function toggleExperienceFields() {
    const choice = document.querySelector('input[name="hasExperience"]:checked')?.value;
    wrapper.hidden = choice !== 'oui';
    noneNote.hidden = choice !== 'non';
  }
  document.querySelectorAll('input[name="hasExperience"]').forEach(radio => radio.addEventListener('change', toggleExperienceFields));

  function syncCards() {
    const cards = container.querySelectorAll('.experience-item');
    cards.forEach((card, index) => {
      card.querySelector('.remove-experience').hidden = cards.length === 1;
      card.querySelector('.experience-item-num').textContent = index + 1;
    });
  }

  function addExperience() {
    const index = container.querySelectorAll('.experience-item').length;
    const card = template.cloneNode(true);
    card.dataset.index = index;
    card.querySelectorAll('[name], [id], label[for]').forEach(el => {
      if (el.name) el.name = el.name.replace('experiences[0]', `experiences[${index}]`);
      if (el.id) el.id = el.id.replace('experiences_0_', `experiences_${index}_`);
      if (el.htmlFor) el.htmlFor = el.htmlFor.replace('experiences_0_', `experiences_${index}_`);
    });
    container.appendChild(card);
    syncCards();
    card.querySelector('input').focus();
  }

  container.addEventListener('click', event => {
    const removeButton = event.target.closest('.remove-experience');
    if (!removeButton) return;
    removeButton.closest('.experience-item')?.remove();
    syncCards();
  });

  // Compteur de caractères des missions
  container.addEventListener('input', event => {
    const field = event.target.closest('textarea[data-char-counter]');
    if (!field) return;
    const counter = field.parentElement.querySelector('.pgde-char-count');
    if (counter) counter.textContent = `${field.value.length} / ${field.maxLength}`;
  });

  addBtn.addEventListener('click', addExperience);
  toggleExperienceFields();
  syncCards();
})();
</script>
