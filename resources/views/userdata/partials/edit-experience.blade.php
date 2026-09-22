<!-- Step 3: Expérience professionnelle -->
<div class="form-step" id="step-3" style="display: none;">
  <fieldset>
    <legend style="background-color: #fff; border: 2px solid green; border-radius: 8px; padding: 10px 15px; text-align: center; font-size: 1.0em; font-weight: bold; color:green; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
      <h3 style="margin: 0; font-family: 'Bold'; text-transform: uppercase; letter-spacing: 1px;">Étape 3 : Expérience professionnelle</h3>
    </legend>

    @php
      $expList = $experiences ?? [];
      if (empty($expList) && (!empty($userdata->posteoccupe) || !empty($userdata->employeur))) {
          $expList = [[
              'description' => '',
              'years' => $userdata->nombreanneeexpe ?? '',
              'poste' => $userdata->posteoccupe ?? '',
              'employeur' => $userdata->employeur ?? ''
          ]];
      }
      $hasExpVal = (!empty($expList) || !empty($userdata->posteoccupe) || !empty($userdata->employeur)) ? 'oui' : 'non';
    @endphp

    <div class="form-group mt-3">
      <label for="hasExperience">Avez-vous une expérience professionnelle ?</label>
      <select id="hasExperience" name="hasExperience" class="form-control" onchange="toggleExperienceFields()">
        <option value="non" {{ $hasExpVal === 'non' ? 'selected' : '' }}>Non</option>
        <option value="oui" {{ $hasExpVal === 'oui' ? 'selected' : '' }}>Oui</option>
      </select>
    </div>

    <div id="experience-wrapper" style="{{ $hasExpVal === 'oui' ? '' : 'display: none;' }}">
      <div id="experience-container" class="space-y-4">
        @if(!empty($expList) && count($expList) > 0)
          @foreach($expList as $index => $exp)
            <div class="form-group experience-item rounded-md p-3 bg-white shadow-sm border mt-3" data-index="{{ $index }}">
              <div class="flex gap-5" style="display: flex; gap: 20px;">
                <div class="flex-1" style="flex: 1;"><label for="experiences_{{ $index }}_description"><i class="fas fa-briefcase" style="color:#00626D;"></i> Description de l'expérience</label><textarea id="experiences_{{ $index }}_description" name="experiences[{{ $index }}][description]" class="form-control" placeholder="Décrivez votre expérience">{{ $exp['description'] ?? '' }}</textarea></div>
                <div class="flex-1" style="flex: 1;"><label for="experiences_{{ $index }}_years"><i class="fas fa-cogs" style="color:#00626D;"></i> Nombre d'années d'expérience</label><input type="number" id="experiences_{{ $index }}_years" name="experiences[{{ $index }}][years]" value="{{ $exp['years'] ?? '' }}" class="form-control" placeholder="Années d'expérience"></div>
              </div>
              <div class="flex gap-5 mt-3" style="display: flex; gap: 20px; margin-top: 15px;">
                <div class="flex-1" style="flex: 1;"><label for="experiences_{{ $index }}_poste"><i class="fas fa-briefcase" style="color:#00626D;"></i> Poste occupé</label><input type="text" id="experiences_{{ $index }}_poste" name="experiences[{{ $index }}][poste]" value="{{ $exp['poste'] ?? '' }}" class="form-control" placeholder="Poste occupé"></div>
                <div class="flex-1" style="flex: 1;"><label for="experiences_{{ $index }}_employeur"><i class="fas fa-building" style="color:#00626D;"></i> Employeur</label><input type="text" id="experiences_{{ $index }}_employeur" name="experiences[{{ $index }}][employeur]" value="{{ $exp['employeur'] ?? '' }}" class="form-control" placeholder="Employeur"></div>
              </div>
              <div class="mt-3 flex justify-end"><button type="button" class="remove-experience px-3 py-1 rounded text-white" style="background:#f56565; {{ $loop->first && count($expList) === 1 ? 'display:none;' : '' }}">Supprimer</button></div>
            </div>
          @endforeach
        @else
          <div class="form-group experience-item rounded-md p-3 bg-white shadow-sm border mt-3" data-index="0">
            <div class="flex gap-5" style="display: flex; gap: 20px;"><div class="flex-1" style="flex: 1;"><label for="experiences_0_description"><i class="fas fa-briefcase" style="color:#00626D;"></i> Description de l'expérience</label><textarea id="experiences_0_description" name="experiences[0][description]" class="form-control" placeholder="Décrivez votre expérience"></textarea></div><div class="flex-1" style="flex: 1;"><label for="experiences_0_years"><i class="fas fa-cogs" style="color:#00626D;"></i> Nombre d'années d'expérience</label><input type="number" id="experiences_0_years" name="experiences[0][years]" class="form-control" placeholder="Années d'expérience"></div></div>
            <div class="flex gap-5 mt-3" style="display: flex; gap: 20px; margin-top: 15px;"><div class="flex-1" style="flex: 1;"><label for="experiences_0_poste"><i class="fas fa-briefcase" style="color:#00626D;"></i> Poste occupé</label><input type="text" id="experiences_0_poste" name="experiences[0][poste]" class="form-control" placeholder="Poste occupé"></div><div class="flex-1" style="flex: 1;"><label for="experiences_0_employeur"><i class="fas fa-building" style="color:#00626D;"></i> Employeur</label><input type="text" id="experiences_0_employeur" name="experiences[0][employeur]" class="form-control" placeholder="Employeur"></div></div>
            <div class="mt-3 flex justify-end"><button type="button" class="remove-experience px-3 py-1 rounded text-white" style="background:#f56565; display:none;">Supprimer</button></div>
          </div>
        @endif
      </div>

      <div id="add-experience-bar" class="mt-4"><button type="button" id="add-experience" class="flex items-center px-4 py-2 rounded text-white" style="background:#06843F;"><i class="fas fa-plus mr-2"></i> Ajouter une expérience</button></div>
    </div>

    <div class="form-group flex justify-start mt-4">
      <button type="button" class="prev-step"><i class="fas fa-arrow-left"></i> <span>Précédent</span></button>
      <button type="button" class="next-step flex items-center"><span>Suivant</span> <i class="fas fa-arrow-right ml-2"></i></button>
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
      const desc = item.querySelector('textarea');
      const years = item.querySelector('input[type="number"]');
      const textInputs = item.querySelectorAll('input[type="text"]');
      const remove = item.querySelector('.remove-experience');
      if (desc) desc.name = `experiences[${idx}][description]`;
      if (years) years.name = `experiences[${idx}][years]`;
      if (textInputs[0]) textInputs[0].name = `experiences[${idx}][poste]`;
      if (textInputs[1]) textInputs[1].name = `experiences[${idx}][employeur]`;
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
    item.className = 'form-group experience-item rounded-md p-3 bg-white shadow-sm border mt-3';
    item.innerHTML = `<div class="flex gap-5" style="display:flex;gap:20px;"><div class="flex-1"><label><i class="fas fa-briefcase" style="color:#00626D;"></i> Description de l'expérience</label><textarea name="experiences[${index}][description]" class="form-control" placeholder="Décrivez votre expérience"></textarea></div><div class="flex-1"><label><i class="fas fa-cogs" style="color:#00626D;"></i> Nombre d'années d'expérience</label><input type="number" name="experiences[${index}][years]" class="form-control" placeholder="Années d'expérience"></div></div><div class="flex gap-5 mt-3" style="display:flex;gap:20px;"><div class="flex-1"><label><i class="fas fa-briefcase" style="color:#00626D;"></i> Poste occupé</label><input type="text" name="experiences[${index}][poste]" class="form-control" placeholder="Poste occupé"></div><div class="flex-1"><label><i class="fas fa-building" style="color:#00626D;"></i> Employeur</label><input type="text" name="experiences[${index}][employeur]" class="form-control" placeholder="Employeur"></div></div><div class="mt-3 flex justify-end"><button type="button" class="remove-experience px-3 py-1 rounded text-white" style="background:#f56565;">Supprimer</button></div>`;
    container.appendChild(item);
    bindDelete(item.querySelector('.remove-experience'));
    reindexExperiences();
  });

  toggleExperienceFields();
});
</script>
