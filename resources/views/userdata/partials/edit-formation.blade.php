<!-- Step 2: Formations (multi) -->
<div class="form-step" id="step-2" style="display: none;">
  <fieldset>
    <legend style="background-color: #fff; border: 2px solid green; border-radius: 8px; padding: 10px 15px; text-align: center; font-size: 1.0em; font-weight: bold; color:green; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
      <h3 style="margin: 0; font-family: 'Bold'; text-transform: uppercase; letter-spacing: 1px;">Étape 2 : Formations & Diplômes</h3>
    </legend>

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
        <div class="form-group formation-item rounded-md p-3 bg-white shadow-sm border mt-3" data-index="{{ $i }}">
          <div class="flex gap-5" style="display: flex; gap: 20px;">
            <div class="flex-1" style="flex: 1;">
              <label for="formations_{{ $i }}_academic_id"><i class="fas fa-graduation-cap" style="color:#00626D;"></i> Niveau de formation <span class="text-red-500 ml-1" style="color:red;">*</span></label>
              <select name="formations[{{ $i }}][academic_id]" id="formations_{{ $i }}_academic_id" class="form-control shadow-sm academic-select" required>
                <option value="" disabled {{ empty($currentAid) ? 'selected' : '' }}>-- Choisir le niveau de formation --</option>
                <option value="sansdiplome" {{ $isSansDiplome ? 'selected' : '' }}>Sans diplôme</option>
                @foreach($academins as $academin)
                  <option value="{{ $academin->id }}" {{ (!$isSansDiplome && $currentAid == $academin->id) ? 'selected' : '' }}>{{ $academin->libelle }}</option>
                @endforeach
              </select>
            </div>
            <div class="flex-1 degree-only" style="flex: 1; {{ $isSansDiplome ? 'display: none;' : '' }}">
              <label for="formations_{{ $i }}_diplome"><i class="fas fa-graduation-cap" style="color:#00626D;"></i> Intitulé diplôme</label>
              <input type="text" id="formations_{{ $i }}_diplome" name="formations[{{ $i }}][diplome]" value="{{ $form['diplome'] ?? '' }}" class="form-control" placeholder="Intitulé diplôme">
            </div>
          </div>

          <div class="flex gap-5 mt-3 degree-only" style="display: flex; gap: 20px; margin-top: 15px; {{ $isSansDiplome ? 'display: none !important;' : '' }}">
            <div class="flex-1" style="flex: 1;">
              <label for="formations_{{ $i }}_anneediplome"><i class="fas fa-calendar-check" style="color:#00626D;"></i> Année d'obtention</label>
              <input type="number" id="formations_{{ $i }}_anneediplome" name="formations[{{ $i }}][anneediplome]" value="{{ $form['anneediplome'] ?? '' }}" class="form-control" placeholder="Année d'obtention">
            </div>
            <div class="flex-1" style="flex: 1;">
              <label for="formations_{{ $i }}_specialite"><i class="fas fa-cogs" style="color:#00626D;"></i> Spécialité</label>
              <input type="text" id="formations_{{ $i }}_specialite" name="formations[{{ $i }}][specialite]" value="{{ $form['specialite'] ?? '' }}" class="form-control" placeholder="Spécialité">
            </div>
          </div>

          <div class="flex gap-5 mt-3 degree-only" style="display: flex; gap: 20px; margin-top: 15px; {{ $isSansDiplome ? 'display: none !important;' : '' }}">
            <div class="flex-1" style="flex: 1;">
              <label for="formations_{{ $i }}_etablissementdiplome"><i class="fas fa-school" style="color:#00626D;"></i> Institut</label>
              <input type="text" id="formations_{{ $i }}_etablissementdiplome" name="formations[{{ $i }}][etablissementdiplome]" value="{{ $form['etablissementdiplome'] ?? '' }}" class="form-control" placeholder="Institut">
            </div>
            <div class="flex-1" style="flex: 1;">
              <label for="formations_{{ $i }}_diplome_file"><i class="fas fa-file-alt" style="color:#00626D;"></i> Joindre un justificatif (facultatif, 8 Mo max)</label>
              @if(!empty($form['diplome_file']))
                <input type="hidden" id="formations_{{ $i }}_existing_diplome_file" name="formations[{{ $i }}][existing_diplome_file]" value="{{ $form['diplome_file'] }}">
                <div class="small mb-2"><i class="fas fa-paperclip me-1"></i><a href="{{ asset($form['diplome_file']) }}" target="_blank">{{ basename($form['diplome_file']) }}</a> <span class="text-muted">(choisir un fichier pour le remplacer)</span></div>
              @endif
              <input type="file" id="formations_{{ $i }}_diplome_file" name="formations[{{ $i }}][diplome_file]" accept=".pdf,.doc,.docx,.rtf,.txt,.png,.jpg,.jpeg" class="form-control">
            </div>
          </div>

          <div class="mt-3 flex justify-end" style="margin-top: 10px; text-align: right;">
            <button type="button" class="remove-formation px-3 py-1 rounded text-white" style="background:#f56565; {{ ($loop->first && count($formList) === 1) ? 'display:none;' : '' }}">Supprimer</button>
          </div>
        </div>
      @endforeach
    </div>

    <div id="add-formation-bar" class="mt-4" style="margin-top: 15px;">
      <button type="button" id="add-formation" class="flex items-center px-4 py-2 rounded text-white" style="background:#06843F;"><i class="fas fa-plus mr-2"></i> Ajouter une formation</button>
    </div>

    <div class="form-group flex justify-start mt-4">
      <button type="button" id="prev" class="prev-step"><i class="fas fa-arrow-left"></i> <span>Précédent</span></button>
      <button type="button" class="next-step flex items-center" id="suivant"><span>Suivant</span> <i class="fas fa-arrow-right ml-2"></i></button>
    </div>
  </fieldset>
</div>

<script>
(function(){
  const container = document.getElementById('formation-container');
  const addBtn = document.getElementById('add-formation');

  function tplFormation(i){
    return `
      <div class="form-group formation-item rounded-md p-3 bg-white shadow-sm border mt-3" data-index="${i}">
        <div class="flex gap-5" style="display: flex; gap: 20px;">
          <div class="flex-1" style="flex: 1;"><label for="formations_${i}_academic_id"><i class="fas fa-graduation-cap" style="color:#00626D;"></i> Niveau de formation <span class="text-red-500 ml-1" style="color:red;">*</span></label><select name="formations[${i}][academic_id]" id="formations_${i}_academic_id" class="form-control shadow-sm academic-select" required><option value="" disabled selected>-- Choisir le niveau de formation --</option><option value="sansdiplome">Sans diplôme</option>@foreach($academins as $academin)<option value="{{ $academin->id }}">{{ $academin->libelle }}</option>@endforeach</select></div>
          <div class="flex-1 degree-only" style="flex: 1;"><label for="formations_${i}_diplome"><i class="fas fa-graduation-cap" style="color:#00626D;"></i> Intitulé diplôme</label><input type="text" id="formations_${i}_diplome" name="formations[${i}][diplome]" class="form-control" placeholder="Intitulé diplôme"></div>
        </div>
        <div class="flex gap-5 mt-3 degree-only" style="display: flex; gap: 20px; margin-top: 15px;"><div class="flex-1" style="flex: 1;"><label for="formations_${i}_anneediplome"><i class="fas fa-calendar-check" style="color:#00626D;"></i> Année d'obtention</label><input type="number" id="formations_${i}_anneediplome" name="formations[${i}][anneediplome]" class="form-control" placeholder="Année d'obtention"></div><div class="flex-1" style="flex: 1;"><label for="formations_${i}_specialite"><i class="fas fa-cogs" style="color:#00626D;"></i> Spécialité</label><input type="text" id="formations_${i}_specialite" name="formations[${i}][specialite]" class="form-control" placeholder="Spécialité"></div></div>
        <div class="flex gap-5 mt-3 degree-only" style="display: flex; gap: 20px; margin-top: 15px;"><div class="flex-1" style="flex: 1;"><label for="formations_${i}_etablissementdiplome"><i class="fas fa-school" style="color:#00626D;"></i> Institut</label><input type="text" id="formations_${i}_etablissementdiplome" name="formations[${i}][etablissementdiplome]" class="form-control" placeholder="Institut"></div><div class="flex-1" style="flex: 1;"><label for="formations_${i}_diplome_file"><i class="fas fa-file-alt" style="color:#00626D;"></i> Joindre un justificatif (facultatif, 8 Mo max)</label><input type="file" id="formations_${i}_diplome_file" name="formations[${i}][diplome_file]" accept=".pdf,.doc,.docx,.rtf,.txt,.png,.jpg,.jpeg" class="form-control"></div></div>
        <div class="mt-3 flex justify-end" style="margin-top: 10px; text-align: right;"><button type="button" class="remove-formation px-3 py-1 rounded text-white" style="background:#f56565;">Supprimer</button></div>
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
    if (delBtn) delBtn.addEventListener('click', () => { block.remove(); reindexFormations(); });
  }

  if (container) container.querySelectorAll('.formation-item').forEach(wireBlock);
  reindexFormations();

  if (addBtn && container) addBtn.addEventListener('click', () => {
    const index = container.querySelectorAll('.formation-item').length;
    container.insertAdjacentHTML('beforeend', tplFormation(index));
    wireBlock(container.lastElementChild);
    reindexFormations();
  });
})();
</script>
