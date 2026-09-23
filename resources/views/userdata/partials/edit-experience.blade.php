<!-- Step 3: Expérience professionnelle -->
<div class="form-step" id="step-3" style="display: none;">
  <fieldset>
    <div class="pgde-step-intro">
      <div class="pgde-step-kicker">Étape 3 sur 4</div>
      <h2>Expérience professionnelle</h2>
      <p>Détaillez vos expériences professionnelles et compétences acquises.</p>
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
      $hasExpVal = (!empty($expList) || !empty($userdata->posteoccupe) || !empty($userdata->employeur)) ? 'oui' : 'non';
    @endphp

    <div class="form-group mb-4">
      <label for="hasExperience" class="mb-2">
        <i class="fas fa-briefcase"></i> Avez-vous une expérience professionnelle ?
      </label>
      <select id="hasExperience" name="hasExperience" class="form-select" onchange="toggleExperienceFields()" style="max-width: 320px;">
        <option value="non" {{ $hasExpVal === 'non' ? 'selected' : '' }}>Non</option>
        <option value="oui" {{ $hasExpVal === 'oui' ? 'selected' : '' }}>Oui</option>
      </select>
    </div>

    <div id="experience-wrapper" style="{{ $hasExpVal === 'oui' ? '' : 'display: none;' }}">
      <div id="experience-container" class="space-y-4">
        @if(!empty($expList) && count($expList) > 0)
          @foreach($expList as $index => $exp)
            <div class="experience-item" data-index="{{ $index }}">
              <div class="formation-item-header">
                <span class="formation-item-badge">
                  <i class="fas fa-briefcase"></i> Expérience #<span class="experience-item-num">{{ $index + 1 }}</span>
                </span>
                <button type="button" class="btn-remove-item remove-experience" style="{{ $loop->first && count($expList) === 1 ? 'display:none;' : '' }}">
                  <i class="fas fa-trash-alt"></i> Supprimer
                </button>
              </div>

              <div class="pgde-grid-2">
                <div class="form-group mb-0">
                  <label for="experiences_{{ $index }}_poste">
                    <i class="fas fa-user-tie"></i> Poste occupé
                  </label>
                  <input type="text" id="experiences_{{ $index }}_poste" name="experiences[{{ $index }}][poste]" value="{{ $exp['poste'] ?? '' }}" class="form-control" placeholder="ex: Chef de projet">
                </div>
                <div class="form-group mb-0">
                  <label for="experiences_{{ $index }}_employeur">
                    <i class="fas fa-building"></i> Entreprise / Employeur
                  </label>
                  <input type="text" id="experiences_{{ $index }}_employeur" name="experiences[{{ $index }}][employeur]" value="{{ $exp['employeur'] ?? '' }}" class="form-control" placeholder="ex: Sonatel">
                </div>
              </div>

              <div class="pgde-grid-2 mt-3">
                <div class="form-group mb-0">
                  <label for="experiences_{{ $index }}_years">
                    <i class="fas fa-clock"></i> Nombre d'années d'expérience
                  </label>
                  <input type="number" id="experiences_{{ $index }}_years" name="experiences[{{ $index }}][years]" value="{{ $exp['years'] ?? '' }}" class="form-control" placeholder="ex: 3" min="0">
                </div>
                <div class="form-group mb-0">
                  <label for="experiences_{{ $index }}_description">
                    <i class="fas fa-align-left"></i> Description des missions
                  </label>
                  <textarea id="experiences_{{ $index }}_description" name="experiences[{{ $index }}][description]" class="form-control" rows="2" placeholder="Décrivez vos principales tâches et réalisations">{{ $exp['description'] ?? '' }}</textarea>
                </div>
              </div>
            </div>
          @endforeach
        @else
          <div class="experience-item" data-index="0">
            <div class="formation-item-header">
              <span class="formation-item-badge">
                <i class="fas fa-briefcase"></i> Expérience #<span class="experience-item-num">1</span>
              </span>
              <button type="button" class="btn-remove-item remove-experience" style="display:none;">
                <i class="fas fa-trash-alt"></i> Supprimer
              </button>
            </div>

            <div class="pgde-grid-2">
              <div class="form-group mb-0">
                <label for="experiences_0_poste">
                  <i class="fas fa-user-tie"></i> Poste occupé
                </label>
                <input type="text" id="experiences_0_poste" name="experiences[0][poste]" class="form-control" placeholder="ex: Chef de projet">
              </div>
              <div class="form-group mb-0">
                <label for="experiences_0_employeur">
                  <i class="fas fa-building"></i> Entreprise / Employeur
                </label>
                <input type="text" id="experiences_0_employeur" name="experiences[0][employeur]" class="form-control" placeholder="ex: Sonatel">
              </div>
            </div>

            <div class="pgde-grid-2 mt-3">
              <div class="form-group mb-0">
                <label for="experiences_0_years">
                  <i class="fas fa-clock"></i> Nombre d'années d'expérience
                </label>
                <input type="number" id="experiences_0_years" name="experiences[0][years]" class="form-control" placeholder="ex: 3" min="0">
              </div>
              <div class="form-group mb-0">
                <label for="experiences_0_description">
                  <i class="fas fa-align-left"></i> Description des missions
                </label>
                <textarea id="experiences_0_description" name="experiences[0][description]" class="form-control" rows="2" placeholder="Décrivez vos principales tâches et réalisations"></textarea>
              </div>
            </div>
          </div>
        @endif
      </div>

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
  const hasExp = document.getElementById('hasExperience');
  const wrapper = document.getElementById('experience-wrapper');
  if (hasExp && wrapper) wrapper.style.display = hasExp.value === 'oui' ? '' : 'none';
}

document.addEventListener('DOMContentLoaded', function () {
  const container = document.getElementById('experience-container');
  const addBtn = document.getElementById('add-experience');

  function reindexExperiences() {
    if (!container) return;
    const items = container.querySelectorAll('.experience-item');
    items.forEach((item, idx) => {
      item.dataset.index = idx;
      const numBadge = item.querySelector('.experience-item-num');
      if (numBadge) numBadge.textContent = idx + 1;
      const desc = item.querySelector('textarea');
      const years = item.querySelector('input[type="number"]');
      const textInputs = item.querySelectorAll('input[type="text"]');
      const remove = item.querySelector('.remove-experience');
      if (textInputs[0]) textInputs[0].name = `experiences[${idx}][poste]`;
      if (textInputs[1]) textInputs[1].name = `experiences[${idx}][employeur]`;
      if (years) years.name = `experiences[${idx}][years]`;
      if (desc) desc.name = `experiences[${idx}][description]`;
      if (remove) remove.style.display = items.length > 1 ? '' : 'none';
    });
  }

  function bindDelete(button) {
    button.addEventListener('click', function () {
      const item = button.closest('.experience-item');
      if (item) { item.remove(); reindexExperiences(); }
    });
  }

  if (container) container.querySelectorAll('.remove-experience').forEach(bindDelete);
  reindexExperiences();

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
          <label><i class="fas fa-user-tie"></i> Poste occupé</label>
          <input type="text" name="experiences[${index}][poste]" class="form-control" placeholder="ex: Chef de projet">
        </div>
        <div class="form-group mb-0">
          <label><i class="fas fa-building"></i> Entreprise / Employeur</label>
          <input type="text" name="experiences[${index}][employeur]" class="form-control" placeholder="ex: Sonatel">
        </div>
      </div>
      <div class="pgde-grid-2 mt-3">
        <div class="form-group mb-0">
          <label><i class="fas fa-clock"></i> Nombre d'années d'expérience</label>
          <input type="number" name="experiences[${index}][years]" class="form-control" placeholder="ex: 3" min="0">
        </div>
        <div class="form-group mb-0">
          <label><i class="fas fa-align-left"></i> Description des missions</label>
          <textarea name="experiences[${index}][description]" class="form-control" rows="2" placeholder="Décrivez vos principales tâches et réalisations"></textarea>
        </div>
      </div>
    `;
    container.appendChild(item);
    bindDelete(item.querySelector('.remove-experience'));
    reindexExperiences();
  });
});
</script>
