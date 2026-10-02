@php
  // Niveaux proposés (« Sans diplôme » est ajouté à part, en premier)
  $academicOptions = $academins->filter(fn ($academin) =>
      !in_array((int) $academin->id, [14, 20], true) && \Illuminate\Support\Str::slug($academin->libelle) !== 'sans-diplome'
  );
@endphp

<!-- Étape 2 : formation (une carte par diplôme) -->
<div class="form-step" id="step-2" style="display:none;">
  <fieldset>
    <div class="pgde-step-intro">
      <div class="pgde-step-kicker">Étape 2 sur 4</div>
      <h2>Formation & diplômes</h2>
      <p>Ajoutez vos diplômes, du plus récent au plus ancien. Le justificatif est facultatif.</p>
    </div>

    <div id="formation-container" class="pgde-item-list">
      <!-- Carte diplôme n°1 -->
      <div class="formation-item pgde-item-card" data-index="0">
        <div class="pgde-item-head">
          <span class="pgde-item-badge"><i class="fas fa-graduation-cap" aria-hidden="true"></i> Diplôme <span class="formation-item-num">1</span></span>
          <button type="button" class="btn-remove-item remove-formation" hidden><i class="fas fa-trash-can" aria-hidden="true"></i> Retirer</button>
        </div>

        <div class="pgde-grid-2">
          <div class="form-group">
            <label for="formations_0_academic_id">Niveau <span class="pgde-req">*</span></label>
            <select name="formations[0][academic_id]" id="formations_0_academic_id" class="form-select academic-select" required>
              <option value="" disabled selected>Choisir le niveau</option>
              <option value="sansdiplome">Sans diplôme</option>
              @foreach($academicOptions as $academin)
                <option value="{{ $academin->id }}">{{ $academin->libelle }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group diplome-field">
            <label for="formations_0_diplome">Intitulé du diplôme</label>
            <input type="text" id="formations_0_diplome" name="formations[0][diplome]" class="form-control" placeholder="ex : Licence en comptabilité" maxlength="255">
          </div>
        </div>

        <div class="pgde-grid-2 degree-only">
          <div class="form-group">
            <label for="formations_0_etablissementdiplome">Établissement</label>
            <input type="text" id="formations_0_etablissementdiplome" name="formations[0][etablissementdiplome]" class="form-control" placeholder="ex : Université Cheikh Anta Diop" maxlength="255">
          </div>
          <div class="form-group">
            <label for="formations_0_specialite">Spécialité</label>
            <input type="text" id="formations_0_specialite" name="formations[0][specialite]" class="form-control" placeholder="ex : Finance" maxlength="255">
          </div>
        </div>

        <div class="pgde-grid-2 degree-only">
          <div class="form-group">
            <label for="formations_0_anneediplome">Année d'obtention</label>
            <input type="number" id="formations_0_anneediplome" name="formations[0][anneediplome]" class="form-control" placeholder="ex : {{ now()->year - 2 }}" min="1900" max="{{ now()->year }}" inputmode="numeric">
          </div>
          <div class="form-group">
            <span class="pgde-group-label">Justificatif <span class="pgde-optional">facultatif</span></span>
            <label class="pgde-file" for="formations_0_diplome_file">
              <i class="fas fa-cloud-arrow-up" aria-hidden="true"></i>
              <span class="pgde-file-text"><strong>Joindre le diplôme</strong><small>PDF ou image · 4 Mo max</small></span>
              <input type="file" id="formations_0_diplome_file" name="formations[0][diplome_file]" accept=".pdf,.doc,.docx,.rtf,.txt,.png,.jpg,.jpeg" class="pgde-visually-hidden-input">
            </label>
          </div>
        </div>
      </div>
    </div>

    <div id="add-formation-bar" class="pgde-add-bar">
      <button type="button" id="add-formation" class="pgde-add-button">
        <i class="fas fa-plus" aria-hidden="true"></i> Ajouter un autre diplôme
      </button>
      <p id="no-diploma-formation-note" class="no-diploma-formation-note" hidden>
        <i class="fas fa-circle-info" aria-hidden="true"></i> Avec « Sans diplôme », une seule ligne de formation suffit.
      </p>
    </div>

    <div class="pgde-action-buttons">
      <button type="button" class="prev-step"><i class="fas fa-arrow-left" aria-hidden="true"></i> <span>Précédent</span></button>
      <button type="button" class="next-step"><span>Suivant</span> <i class="fas fa-arrow-right" aria-hidden="true"></i></button>
    </div>
  </fieldset>
</div>

<script>
/* ----------------------------------------------------------------
   Formation — champs du diplôme masqués avec « Sans diplôme »
   toggleDegreeFields est global : restoreDraft() (create.blade.php)
   l'appelle après avoir rempli le brouillon.
---------------------------------------------------------------- */
window.toggleDegreeFields = function (block) {
  if (!block) return;
  const select = block.querySelector('.academic-select');
  const isSans = Boolean(select && ['sansdiplome', '14', '20'].includes(select.value));

  const diplomeWrapper = block.querySelector('.diplome-field');
  if (diplomeWrapper) {
    diplomeWrapper.hidden = isSans;
    if (isSans) diplomeWrapper.querySelector('input').value = '';
  }
  block.querySelectorAll('.degree-only').forEach(row => {
    row.hidden = isSans;
    if (isSans) row.querySelectorAll('input, select, textarea').forEach(input => { input.value = ''; input.removeAttribute('required'); });
  });
  block.classList.toggle('is-no-diploma', isSans);
};

(function () {
  const container = document.getElementById('formation-container');
  const addBtn = document.getElementById('add-formation');
  const noDiplomaNote = document.getElementById('no-diploma-formation-note');
  if (!container || !addBtn) return;
  const firstCard = container.querySelector('.formation-item');
  const template = firstCard.cloneNode(true);

  function syncAddFormationButton() {
    const hasNoDiploma = Array.from(container.querySelectorAll('.academic-select'))
      .some(select => ['sansdiplome', '14', '20'].includes(select.value));
    addBtn.disabled = hasNoDiploma;
    addBtn.setAttribute('aria-disabled', String(hasNoDiploma));
    if (noDiplomaNote) noDiplomaNote.hidden = !hasNoDiploma;
    // Le bouton « Retirer » n'apparaît que s'il y a plusieurs diplômes
    const cards = container.querySelectorAll('.formation-item');
    cards.forEach((card, index) => {
      card.querySelector('.remove-formation').hidden = cards.length === 1;
      card.querySelector('.formation-item-num').textContent = index + 1;
    });
  }

  function wireBlock(block) {
    const select = block.querySelector('.academic-select');
    select?.addEventListener('change', () => { window.toggleDegreeFields(block); syncAddFormationButton(); });
    window.toggleDegreeFields(block);
    syncAddFormationButton();
  }

  function addFormation() {
    if (addBtn.disabled) return;
    const index = container.querySelectorAll('.formation-item').length;
    const card = template.cloneNode(true);
    card.dataset.index = index;
    // Renomme les champs formations[0][…] → formations[index][…] et leurs identifiants
    card.querySelectorAll('[name], [id], label[for]').forEach(el => {
      if (el.name) el.name = el.name.replace('formations[0]', `formations[${index}]`);
      if (el.id) el.id = el.id.replace('formations_0_', `formations_${index}_`);
      if (el.htmlFor) el.htmlFor = el.htmlFor.replace('formations_0_', `formations_${index}_`);
    });
    card.querySelectorAll('input:not([type="file"])').forEach(input => { input.value = ''; });
    card.querySelector('.academic-select').selectedIndex = 0;
    container.appendChild(card);
    wireBlock(card);
    card.querySelector('.academic-select').focus();
  }

  container.addEventListener('click', event => {
    const removeButton = event.target.closest('.remove-formation');
    if (!removeButton) return;
    removeButton.closest('.formation-item')?.remove();
    syncAddFormationButton();
  });

  addBtn.addEventListener('click', addFormation);
  wireBlock(firstCard);
})();

// Zone de dépôt : affiche le nom du fichier choisi (ou un message si trop lourd)
document.addEventListener('change', event => {
  const input = event.target.closest('.pgde-file input[type="file"]');
  if (!input) return;
  const zone = input.closest('.pgde-file');
  const title = zone.querySelector('.pgde-file-text strong');
  const help = zone.querySelector('.pgde-file-text small');
  const file = input.files && input.files[0];
  zone.classList.remove('is-error');
  if (!file) {
    zone.classList.remove('has-file');
    title.textContent = 'Joindre le diplôme';
    help.textContent = 'PDF ou image · 4 Mo max';
    return;
  }
  if (file.size > 4 * 1024 * 1024) {
    input.value = '';
    zone.classList.add('is-error');
    zone.classList.remove('has-file');
    title.textContent = 'Fichier trop lourd';
    help.textContent = `${(file.size / 1048576).toFixed(1)} Mo · 4 Mo maximum`;
    return;
  }
  zone.classList.add('has-file');
  title.textContent = file.name;
  help.textContent = `${(file.size / 1048576).toFixed(1)} Mo · cliquer pour changer`;
});
</script>
