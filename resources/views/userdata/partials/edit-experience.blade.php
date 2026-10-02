<!-- Step 3: Expérience professionnelle -->
<div class="form-step" id="step-3" style="display: none;">
  <fieldset>
    <div class="pgde-step-intro">
      <div class="pgde-step-kicker">Étape 3 sur 4</div>
      <h2>Expérience professionnelle</h2>
      <p>Pour chaque expérience : le poste, l'entreprise, la durée, puis un court résumé de vos missions.</p>
    </div>

    @php
      $expList = $experiences ?? [];
      if (empty($expList) && (!empty($userdata->posteoccupe) || !empty($userdata->employeur))) {
          $rawYears = $userdata->nombreanneeexpe ?? '';
          if (is_numeric($rawYears) && $rawYears > 70) {
              $rawYears = '';
          }
          $expList = [[
              'description' => '',
              'years' => $rawYears,
              'poste' => $userdata->posteoccupe ?? '',
              'employeur' => $userdata->employeur ?? ''
          ]];
      }
      foreach ($expList as $k => $v) {
          if (isset($v['years']) && is_numeric($v['years']) && $v['years'] > 70) {
              $expList[$k]['years'] = '';
          }
      }
      if (empty($expList)) {
          $expList = [['poste' => '', 'employeur' => '', 'years' => '', 'description' => '']];
      }
      $hasExpVal = (!empty($experiences) || !empty($userdata->posteoccupe) || !empty($userdata->employeur)) ? 'oui' : 'non';
    @endphp

    <div class="form-group mb-4">
      <p class="mb-2"><i class="fas fa-briefcase"></i> Avez-vous une expérience professionnelle ?</p>
      <div class="pgde-radio-group" role="radiogroup" aria-label="Expérience professionnelle">
        <label class="pgde-radio-option" for="hasExperienceOui">
          <input type="radio" id="hasExperienceOui" name="hasExperience" value="oui" required {{ $hasExpVal === 'oui' ? 'checked' : '' }}>
          <span>Oui</span>
        </label>
        <label class="pgde-radio-option" for="hasExperienceNon">
          <input type="radio" id="hasExperienceNon" name="hasExperience" value="non" {{ $hasExpVal === 'non' ? 'checked' : '' }}>
          <span>Non</span>
        </label>
      </div>
    </div>

    <div id="experience-wrapper" style="{{ $hasExpVal === 'oui' ? '' : 'display: none;' }}">
      <div id="experience-container" class="space-y-4">
        @foreach($expList as $index => $exp)
          <div class="experience-item" data-index="{{ $index }}" {{ $loop->iteration > 2 ? 'hidden' : '' }}>
            <div class="formation-item-header">
              <span class="formation-item-badge">
                <i class="fas fa-briefcase"></i> Expérience #<span class="experience-item-num">{{ $index + 1 }}</span>
              </span>
              <button type="button" class="btn-remove-item remove-experience" style="{{ count($expList) === 1 ? 'display:none;' : '' }}">
                <i class="fas fa-trash-alt"></i> Supprimer
              </button>
            </div>

            <!-- 1. Poste et entreprise -->
            <div class="pgde-grid-2">
              <div class="form-group mb-0">
                <label for="experiences_{{ $index }}_poste"><i class="fas fa-user-tie"></i> Poste occupé</label>
                <input type="text" id="experiences_{{ $index }}_poste" name="experiences[{{ $index }}][poste]" value="{{ $exp['poste'] ?? '' }}" class="form-control" placeholder="Intitulé du poste, ex : Comptable" maxlength="150">
              </div>
              <div class="form-group mb-0">
                <label for="experiences_{{ $index }}_employeur"><i class="fas fa-building"></i> Entreprise ou employeur</label>
                <input type="text" id="experiences_{{ $index }}_employeur" name="experiences[{{ $index }}][employeur]" value="{{ $exp['employeur'] ?? '' }}" class="form-control" placeholder="Nom de la structure, ex : Sonatel" maxlength="150">
              </div>
            </div>

            <!-- 2. Durée -->
            <div class="pgde-grid-2 mt-3">
              <div class="form-group mb-0">
                <label for="experiences_{{ $index }}_years"><i class="fas fa-clock"></i> Durée (en années)</label>
                <input type="number" id="experiences_{{ $index }}_years" name="experiences[{{ $index }}][years]" value="{{ $exp['years'] ?? '' }}" class="form-control" placeholder="ex : 3" min="0" max="70">
              </div>
            </div>

            <!-- 3. Missions : texte court, limité -->
            <div class="form-group mb-0 mt-3">
              <label for="experiences_{{ $index }}_description"><i class="fas fa-list-check"></i> Missions principales</label>
              <textarea id="experiences_{{ $index }}_description" name="experiences[{{ $index }}][description]" class="form-control" rows="3" maxlength="500" data-char-counter placeholder="En 2 ou 3 phrases : vos tâches et réalisations principales">{{ $exp['description'] ?? '' }}</textarea>
              <div class="pgde-field-foot">
                <span>Facultatif · 500 caractères maximum</span>
                <span class="pgde-char-count" aria-live="polite">{{ mb_strlen($exp['description'] ?? '') }} / 500</span>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <button type="button" id="toggle-more-experiences" class="btn-show-more-items" aria-expanded="false" hidden>
        <i class="fas fa-chevron-down" aria-hidden="true"></i>
        <span></span>
      </button>

      <div id="add-experience-bar" class="mt-4">
        <button type="button" id="add-experience" class="btn-add-item">
          <i class="fas fa-plus"></i> Ajouter une expérience
        </button>
      </div>
    </div>

    <div class="pgde-action-buttons">
      <button type="button" class="prev-step">
        <i class="fas fa-arrow-left"></i> <span>Précédent</span>
      </button>
      <button type="button" class="next-step">
        <span>Suivant</span> <i class="fas fa-arrow-right"></i>
      </button>
    </div>
  </fieldset>
</div>

<script>
function toggleExperienceFields() {
  const hasExp = document.querySelector('input[name="hasExperience"]:checked');
  const wrapper = document.getElementById('experience-wrapper');
  if (wrapper) wrapper.style.display = hasExp?.value === 'oui' ? '' : 'none';
}

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('input[name="hasExperience"]').forEach(radio => {
    radio.addEventListener('change', toggleExperienceFields);
  });
  toggleExperienceFields();

  const container = document.getElementById('experience-container');
  const addBtn = document.getElementById('add-experience');
  const moreBtn = document.getElementById('toggle-more-experiences');

  // Compteur de caractères des missions
  container?.addEventListener('input', event => {
    const field = event.target.closest('textarea[data-char-counter]');
    if (!field) return;
    const counter = field.parentElement.querySelector('.pgde-char-count');
    if (counter) counter.textContent = `${field.value.length} / ${field.maxLength}`;
  });

  function updateExperienceVisibility(showAll = moreBtn?.dataset.expanded === 'true') {
    if (!container || !moreBtn) return;
    const items = Array.from(container.querySelectorAll('.experience-item'));
    items.forEach((item, index) => { item.hidden = !showAll && index >= 2; });
    const extraCount = Math.max(0, items.length - 2);
    moreBtn.hidden = extraCount === 0;
    moreBtn.dataset.expanded = String(showAll);
    moreBtn.setAttribute('aria-expanded', String(showAll));
    moreBtn.querySelector('span').textContent = showAll
      ? 'Voir moins'
      : (extraCount === 1 ? 'Voir l’expérience suivante' : `Voir les ${extraCount} autres expériences`);
    moreBtn.querySelector('i').className = showAll ? 'fas fa-chevron-up' : 'fas fa-chevron-down';
  }

  // Renomme les champs (experiences[i][...]) et les identifiants après ajout ou suppression
  function reindexExperiences() {
    if (!container) return;
    const items = container.querySelectorAll('.experience-item');
    items.forEach((item, idx) => {
      item.dataset.index = idx;
      const numBadge = item.querySelector('.experience-item-num');
      if (numBadge) numBadge.textContent = idx + 1;
      ['poste', 'employeur', 'years', 'description'].forEach(field => {
        const input = item.querySelector(`[name$="[${field}]"]`);
        const label = input ? item.querySelector(`label[for="${input.id}"]`) : null;
        if (!input) return;
        input.name = `experiences[${idx}][${field}]`;
        input.id = `experiences_${idx}_${field}`;
        if (label) label.htmlFor = input.id;
      });
      const remove = item.querySelector('.remove-experience');
      if (remove) remove.style.display = items.length > 1 ? '' : 'none';
    });
  }

  function bindDelete(button) {
    button.addEventListener('click', function () {
      const item = button.closest('.experience-item');
      if (item) {
        item.remove();
        reindexExperiences();
        updateExperienceVisibility();
      }
    });
  }

  if (container) container.querySelectorAll('.remove-experience').forEach(bindDelete);
  reindexExperiences();
  updateExperienceVisibility(false);
  moreBtn?.addEventListener('click', () => updateExperienceVisibility(moreBtn.dataset.expanded !== 'true'));

  if (addBtn && container) addBtn.addEventListener('click', function () {
    const index = container.querySelectorAll('.experience-item').length;
    const item = document.createElement('div');
    item.className = 'experience-item';
    item.dataset.index = index;
    item.innerHTML = `
      <div class="formation-item-header">
        <span class="formation-item-badge">
          <i class="fas fa-briefcase"></i> Expérience #<span class="experience-item-num">${index + 1}</span>
        </span>
        <button type="button" class="btn-remove-item remove-experience">
          <i class="fas fa-trash-alt"></i> Supprimer
        </button>
      </div>
      <div class="pgde-grid-2">
        <div class="form-group mb-0">
          <label for="experiences_${index}_poste"><i class="fas fa-user-tie"></i> Poste occupé</label>
          <input type="text" id="experiences_${index}_poste" name="experiences[${index}][poste]" class="form-control" placeholder="Intitulé du poste, ex : Comptable" maxlength="150">
        </div>
        <div class="form-group mb-0">
          <label for="experiences_${index}_employeur"><i class="fas fa-building"></i> Entreprise ou employeur</label>
          <input type="text" id="experiences_${index}_employeur" name="experiences[${index}][employeur]" class="form-control" placeholder="Nom de la structure, ex : Sonatel" maxlength="150">
        </div>
      </div>
      <div class="pgde-grid-2 mt-3">
        <div class="form-group mb-0">
          <label for="experiences_${index}_years"><i class="fas fa-clock"></i> Durée (en années)</label>
          <input type="number" id="experiences_${index}_years" name="experiences[${index}][years]" class="form-control" placeholder="ex : 3" min="0" max="70">
        </div>
      </div>
      <div class="form-group mb-0 mt-3">
        <label for="experiences_${index}_description"><i class="fas fa-list-check"></i> Missions principales</label>
        <textarea id="experiences_${index}_description" name="experiences[${index}][description]" class="form-control" rows="3" maxlength="500" data-char-counter placeholder="En 2 ou 3 phrases : vos tâches et réalisations principales"></textarea>
        <div class="pgde-field-foot">
          <span>Facultatif · 500 caractères maximum</span>
          <span class="pgde-char-count" aria-live="polite">0 / 500</span>
        </div>
      </div>
    `;
    container.appendChild(item);
    bindDelete(item.querySelector('.remove-experience'));
    reindexExperiences();
    updateExperienceVisibility(true);
  });
});
</script>
