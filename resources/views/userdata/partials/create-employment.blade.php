<!-- Étape 4 : emplois visés -->
<div class="form-step" id="step-4" style="display: none;">
  <fieldset>
    <div class="pgde-step-intro">
      <div class="pgde-step-kicker">Étape 4 sur 4</div>
      <h2>Emplois visés</h2>
      <p>Choisissez deux emplois, chacun dans un secteur. Le premier est votre choix prioritaire.</p>
    </div>

    <!-- Deux cartes de choix : secteur → emploi → expérience dans ce métier -->
    <div class="pgde-choice-grid">
      @foreach ([1 => ['1er choix', 'Votre emploi prioritaire'], 2 => ['2e choix', 'Une autre possibilité']] as $rank => [$rankTitle, $rankHelp])
        <section class="pgde-choice-card {{ $rank === 1 ? 'is-primary' : '' }}" aria-labelledby="choice-title-{{ $rank }}">
          <div class="pgde-choice-head">
            <span class="pgde-choice-rank" aria-hidden="true">{{ $rank }}</span>
            <div>
              <h3 id="choice-title-{{ $rank }}">{{ $rankTitle }}</h3>
              <p>{{ $rankHelp }}</p>
            </div>
          </div>

          <div class="form-group">
            <label for="secteur{{ $rank }}_id">Secteur <span class="pgde-req">*</span></label>
            <select name="secteur{{ $rank }}_id" id="secteur{{ $rank }}_id" class="form-select" required>
              <option value="" disabled selected>Choisir un secteur</option>
              @foreach($secteurs as $secteur)
                <option value="{{ $secteur->id }}">{{ $secteur->libelle }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="emploi{{ $rank }}_id">Emploi <span class="pgde-req">*</span></label>
            <select name="emploi{{ $rank }}_id" id="emploi{{ $rank }}_id" class="form-select" required disabled>
              <option value="" disabled selected>Choisir d'abord le secteur</option>
            </select>
          </div>

          <div class="form-group">
            <label for="anneeexperience{{ $rank }}">Années d'expérience dans ce métier <span class="pgde-optional">facultatif</span></label>
            <input type="number" id="anneeexperience{{ $rank }}" name="anneeexperience{{ $rank }}" class="form-control" placeholder="0" min="0" max="50" inputmode="numeric">
          </div>
        </section>
      @endforeach
    </div>

    <!-- Profil -->
    <section class="pgde-card-section" aria-labelledby="section-profile">
      <h3 id="section-profile" class="pgde-section-title"><i class="fas fa-align-left"></i> Votre profil en quelques mots <span class="pgde-optional">facultatif</span></h3>
      <div class="form-group">
        <label for="cv_summary" class="visually-hidden">Résumé de votre profil</label>
        <textarea id="cv_summary" name="cv_summary" class="form-control" rows="4" maxlength="1000" data-char-counter placeholder="Présentez-vous : vos compétences, vos points forts et ce que vous souhaitez apporter à l'administration."></textarea>
        <div class="pgde-field-foot">
          <span>Ce texte apparaîtra en tête de votre CV.</span>
          <span class="pgde-char-count" aria-live="polite">0 / 1000</span>
        </div>
      </div>
    </section>

    <div class="pgde-action-buttons">
      <button type="button" id="prev" class="prev-step"><i class="fas fa-arrow-left" aria-hidden="true"></i> <span>Précédent</span></button>
      <div class="pgde-submit-area">
        <button type="submit" class="btn-submit-step" aria-disabled="true">
          <i class="fas fa-paper-plane" aria-hidden="true"></i> Envoyer mon dossier
        </button>
      </div>
    </div>
  </fieldset>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  // Secteur choisi → liste des emplois de ce secteur
  function loadJobsForSector(rank) {
    const sector = document.getElementById(`secteur${rank}_id`).value;
    const jobSelect = document.getElementById(`emploi${rank}_id`);
    jobSelect.disabled = true;
    jobSelect.innerHTML = '<option value="" disabled selected>Chargement…</option>';
    if (!sector) {
      jobSelect.innerHTML = '<option value="" disabled selected>Choisir d\'abord le secteur</option>';
      return;
    }
    fetch(`/emplois-par-secteur/${sector}`, { headers: { 'Accept': 'application/json' } })
      .then(response => { if (!response.ok) throw new Error(); return response.json(); })
      .then(jobs => {
        jobSelect.innerHTML = '';
        jobSelect.add(new Option(jobs.length ? 'Choisir un emploi' : 'Aucun emploi dans ce secteur', '', true, true));
        jobSelect.options[0].disabled = true;
        jobs.forEach(job => jobSelect.add(new Option(job.libelle, job.id)));
        jobSelect.disabled = jobs.length === 0;
      })
      .catch(() => {
        jobSelect.innerHTML = '<option value="" disabled selected>Erreur de chargement, réessayez</option>';
      });
  }

  document.getElementById('secteur1_id').addEventListener('change', () => loadJobsForSector(1));
  document.getElementById('secteur2_id').addEventListener('change', () => loadJobsForSector(2));

  // Le brouillon remplit directement la liste des emplois : on la réactive
  ['emploi1_id', 'emploi2_id'].forEach(id => {
    const select = document.getElementById(id);
    new MutationObserver(() => { if (select.options.length > 1) select.disabled = false; })
      .observe(select, { childList: true });
  });

  // Compteur du résumé de profil
  document.getElementById('cv_summary').addEventListener('input', event => {
    const field = event.target;
    field.parentElement.querySelector('.pgde-char-count').textContent = `${field.value.length} / ${field.maxLength}`;
  });
</script>
