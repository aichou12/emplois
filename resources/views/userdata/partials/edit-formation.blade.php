<!-- Step 2: Formations (multi) -->
<div class="form-step" id="step-2" style="display: none;">
  <fieldset>
    <div class="pgde-step-intro">
      <div class="pgde-step-kicker">Étape 2 sur 4</div>
      <h2>Formations & Diplômes</h2>
      <p>Renseignez votre parcours académique et vos diplômes obtenus.</p>
    </div>

    @php
      $formList = $formations ?? [];
      if (empty($formList)) {
          $formList = [[
              'academic_id' => $userdata->academic_id == 20 ? 'sansdiplome' : (string)($userdata->academic_id ?? ''),
              'diplome' => $userdata->diplome ?? '',
              'anneediplome' => $userdata->anneediplome ?? '',
              'specialite' => $userdata->specialite ?? '',
              'etablissementdiplome' => $userdata->etablissementdiplome ?? '',
          ]];
      }
    @endphp

    <div id="formation-container" class="space-y-4">
      @foreach($formList as $i => $form)
        @php
          $currentAid = (string)($form['academic_id'] ?? '');
          $isSansDiplome = ($currentAid === '20' || $currentAid === 'sansdiplome');
        @endphp
        <div class="formation-item" data-index="{{ $i }}" {{ $loop->iteration > 2 ? 'hidden' : '' }}>
          <div class="formation-item-header">
            <span class="formation-item-badge">
              <i class="fas fa-graduation-cap"></i> Formation #<span class="formation-item-num">{{ $i + 1 }}</span>
            </span>
            <button type="button" class="btn-remove-item remove-formation" style="{{ ($loop->first && count($formList) === 1) ? 'display:none;' : '' }}">
              <i class="fas fa-trash-alt"></i> Supprimer
            </button>
          </div>

          <div class="pgde-grid-2">
            <div class="form-group mb-0">
              <label for="formations_{{ $i }}_academic_id">
                <i class="fas fa-graduation-cap"></i> Niveau de formation <span style="color:var(--color-danger)">*</span>
              </label>
              <select name="formations[{{ $i }}][academic_id]" id="formations_{{ $i }}_academic_id" class="form-select academic-select" required>
                <option value="" disabled {{ empty($currentAid) ? 'selected' : '' }}>-- Choisir le niveau de formation --</option>
                <option value="sansdiplome" {{ $isSansDiplome ? 'selected' : '' }}>Sans diplôme</option>
                @foreach($academins as $academin)
                  <option value="{{ $academin->id }}" {{ (!$isSansDiplome && $currentAid == $academin->id) ? 'selected' : '' }}>{{ $academin->libelle }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group mb-0 degree-only" style="{{ $isSansDiplome ? 'display: none;' : '' }}">
              <label for="formations_{{ $i }}_diplome">
                <i class="fas fa-certificate"></i> Intitulé du diplôme
              </label>
              <input type="text" id="formations_{{ $i }}_diplome" name="formations[{{ $i }}][diplome]" value="{{ $form['diplome'] ?? '' }}" class="form-control" placeholder="ex: Licence en Informatique">
            </div>
          </div>

          <div class="pgde-grid-2 mt-3 degree-only" style="{{ $isSansDiplome ? 'display: none !important;' : '' }}">
            <div class="form-group mb-0">
              <label for="formations_{{ $i }}_anneediplome">
                <i class="fas fa-calendar-check"></i> Année d'obtention
              </label>
              <input type="number" id="formations_{{ $i }}_anneediplome" name="formations[{{ $i }}][anneediplome]" value="{{ $form['anneediplome'] ?? '' }}" class="form-control" placeholder="ex: 2022" min="1900" max="{{ now()->year }}">
            </div>
            <div class="form-group mb-0">
              <label for="formations_{{ $i }}_specialite">
                <i class="fas fa-layer-group"></i> Spécialité / Filière
              </label>
              <input type="text" id="formations_{{ $i }}_specialite" name="formations[{{ $i }}][specialite]" value="{{ $form['specialite'] ?? '' }}" class="form-control" placeholder="ex: Génie Logiciel">
            </div>
          </div>

          <div class="pgde-grid-2 mt-3 degree-only" style="{{ $isSansDiplome ? 'display: none !important;' : '' }}">
            <div class="form-group mb-0">
              <label for="formations_{{ $i }}_etablissementdiplome">
                <i class="fas fa-university"></i> Établissement / Institut
              </label>
              <input type="text" id="formations_{{ $i }}_etablissementdiplome" name="formations[{{ $i }}][etablissementdiplome]" value="{{ $form['etablissementdiplome'] ?? '' }}" class="form-control" placeholder="ex: Université Cheikh Anta Diop">
            </div>
            <div class="form-group mb-0">
              <label for="formations_{{ $i }}_diplome_file">
                <i class="fas fa-file-pdf"></i> Justificatif (PDF, image - max 4 Mo)
              </label>
              @if(!empty($form['diplome_file']))
                <input type="hidden" id="formations_{{ $i }}_existing_diplome_file" name="formations[{{ $i }}][existing_diplome_file]" value="{{ $form['diplome_file'] }}">
                <div class="file-preview-pill mb-2">
                  <i class="fas fa-paperclip text-success"></i>
                  <a href="{{ asset($form['diplome_file']) }}" target="_blank" class="fw-semibold text-decoration-none text-dark">{{ basename($form['diplome_file']) }}</a>
                  <span class="text-muted small">(téléverser pour remplacer)</span>
                </div>
              @endif
              <input type="file" id="formations_{{ $i }}_diplome_file" name="formations[{{ $i }}][diplome_file]" accept=".pdf,.doc,.docx,.rtf,.txt,.png,.jpg,.jpeg" class="form-control">
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <button type="button" id="toggle-more-formations" class="btn-show-more-items" aria-expanded="false" hidden>
      <i class="fas fa-chevron-down" aria-hidden="true"></i>
      <span></span>
    </button>

    <div id="add-formation-bar" class="mt-4">
      <button type="button" id="add-formation" class="btn-add-item">
        <i class="fas fa-plus"></i> Ajouter une formation
      </button>
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
(function(){
  const container = document.getElementById('formation-container');
  const addBtn = document.getElementById('add-formation');
  const moreBtn = document.getElementById('toggle-more-formations');

  function updateFormationVisibility(showAll = moreBtn?.dataset.expanded === 'true') {
    if (!container || !moreBtn) return;
    const items = Array.from(container.querySelectorAll('.formation-item'));
    items.forEach((item, index) => { item.hidden = !showAll && index >= 2; });
    const extraCount = Math.max(0, items.length - 2);
    moreBtn.hidden = extraCount === 0;
    moreBtn.dataset.expanded = String(showAll);
    moreBtn.setAttribute('aria-expanded', String(showAll));
    moreBtn.querySelector('span').textContent = showAll
      ? 'Voir moins'
      : (extraCount === 1 ? 'Voir la formation suivante' : `Voir les ${extraCount} autres formations`);
    moreBtn.querySelector('i').className = showAll ? 'fas fa-chevron-up' : 'fas fa-chevron-down';
  }

  function tplFormation(i){
    return `
      <div class="formation-item" data-index="${i}">
        <div class="formation-item-header">
          <span class="formation-item-badge">
            <i class="fas fa-graduation-cap"></i> Formation #<span class="formation-item-num">${i + 1}</span>
          </span>
          <button type="button" class="btn-remove-item remove-formation">
            <i class="fas fa-trash-alt"></i> Supprimer
          </button>
        </div>

        <div class="pgde-grid-2">
          <div class="form-group mb-0">
            <label for="formations_${i}_academic_id">
              <i class="fas fa-graduation-cap"></i> Niveau de formation <span style="color:var(--color-danger)">*</span>
            </label>
            <select name="formations[${i}][academic_id]" id="formations_${i}_academic_id" class="form-select academic-select" required>
              <option value="" disabled selected>-- Choisir le niveau de formation --</option>
              <option value="sansdiplome">Sans diplôme</option>
              @foreach($academins as $academin)
                <option value="{{ $academin->id }}">{{ $academin->libelle }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group mb-0 degree-only">
            <label for="formations_${i}_diplome">
              <i class="fas fa-certificate"></i> Intitulé du diplôme
            </label>
            <input type="text" id="formations_${i}_diplome" name="formations[${i}][diplome]" class="form-control" placeholder="ex: Licence en Informatique">
          </div>
        </div>

        <div class="pgde-grid-2 mt-3 degree-only">
          <div class="form-group mb-0">
            <label for="formations_${i}_anneediplome">
              <i class="fas fa-calendar-check"></i> Année d'obtention
            </label>
            <input type="number" id="formations_${i}_anneediplome" name="formations[${i}][anneediplome]" class="form-control" placeholder="ex: 2022" min="1900" max="{{ now()->year }}">
          </div>
          <div class="form-group mb-0">
            <label for="formations_${i}_specialite">
              <i class="fas fa-layer-group"></i> Spécialité / Filière
            </label>
            <input type="text" id="formations_${i}_specialite" name="formations[${i}][specialite]" class="form-control" placeholder="ex: Génie Logiciel">
          </div>
        </div>

        <div class="pgde-grid-2 mt-3 degree-only">
          <div class="form-group mb-0">
            <label for="formations_${i}_etablissementdiplome">
              <i class="fas fa-university"></i> Établissement / Institut
            </label>
            <input type="text" id="formations_${i}_etablissementdiplome" name="formations[${i}][etablissementdiplome]" class="form-control" placeholder="ex: Université Cheikh Anta Diop">
          </div>
          <div class="form-group mb-0">
            <label for="formations_${i}_diplome_file">
              <i class="fas fa-file-pdf"></i> Justificatif (PDF, image - max 4 Mo)
            </label>
            <input type="file" id="formations_${i}_diplome_file" name="formations[${i}][diplome_file]" accept=".pdf,.doc,.docx,.rtf,.txt,.png,.jpg,.jpeg" class="form-control">
          </div>
        </div>
      </div>`;
  }

  function toggleDegreeFields(block){
    const select = block.querySelector('.academic-select');
    const isSans = select && (select.value === 'sansdiplome' || select.value === '20');
    block.querySelectorAll('.degree-only').forEach(el => {
      el.style.display = isSans ? 'none' : '';
      if (isSans) el.querySelectorAll('input,select,textarea').forEach(input => { input.value = ''; });
    });
  }

  function reindexFormations(){
    if (!container) return;
    const items = container.querySelectorAll('.formation-item');
    items.forEach((item, idx) => {
      item.dataset.index = idx;
      const badgeNum = item.querySelector('.formation-item-num');
      if (badgeNum) badgeNum.textContent = idx + 1;
      const select = item.querySelector('.academic-select');
      const inputs = item.querySelectorAll('input');
      const delBtn = item.querySelector('.remove-formation');
      if (select) select.name = `formations[${idx}][academic_id]`;
      inputs.forEach(input => {
        if (input.type === 'file') { input.name = `formations[${idx}][diplome_file]`; return; }
        if (input.id.includes('existing_diplome_file')) { input.name = `formations[${idx}][existing_diplome_file]`; return; }
        if (input.id.includes('anneediplome')) input.name = `formations[${idx}][anneediplome]`;
        else if (input.id.includes('specialite')) input.name = `formations[${idx}][specialite]`;
        else if (input.id.includes('etablissementdiplome')) input.name = `formations[${idx}][etablissementdiplome]`;
        else if (input.id.includes('diplome')) input.name = `formations[${idx}][diplome]`;
      });
      if (delBtn) delBtn.style.display = items.length > 1 ? '' : 'none';
    });
  }

  function wireBlock(block){
    const select = block.querySelector('.academic-select');
    if (select) { select.addEventListener('change', () => toggleDegreeFields(block)); toggleDegreeFields(block); }
    const delBtn = block.querySelector('.remove-formation');
    if (delBtn) delBtn.addEventListener('click', () => {
      block.remove();
      reindexFormations();
      updateFormationVisibility();
    });
  }

  if (container) container.querySelectorAll('.formation-item').forEach(wireBlock);
  reindexFormations();
  updateFormationVisibility(false);
  moreBtn?.addEventListener('click', () => updateFormationVisibility(moreBtn.dataset.expanded !== 'true'));

  if (addBtn && container) addBtn.addEventListener('click', () => {
    const index = container.querySelectorAll('.formation-item').length;
    container.insertAdjacentHTML('beforeend', tplFormation(index));
    wireBlock(container.lastElementChild);
    reindexFormations();
    updateFormationVisibility(true);
  });
})();
</script>
