<!-- Step 2: Formation (multi) -->
<div class="form-step" id="step-2" style="display:none;">
  <fieldset>
    <div class="pgde-step-intro">
      <div class="pgde-step-kicker">Étape 2 sur 4</div>
      <h2>Formation & diplômes</h2>
      <p>Renseignez votre parcours académique et vos diplômes obtenus.</p>
    </div>

    <div id="formation-container" class="space-y-4">
      <!-- Bloc formation initial (index 0) -->
      <div class="form-group formation-item" data-index="0">
        <div class="flex gap-5">
          <div class="flex-1">
            <label for="formations_0_academic_id">
              <i class="fas fa-graduation-cap" style="color:#00626D;"></i> Niveau de formation
              <span class="text-red-500 ml-1">*</span>
            </label>
            <select name="formations[0][academic_id]" id="formations_0_academic_id"
                    class="form-control shadow-sm academic-select" required>
              <option value="" disabled selected>-- Choisir le niveau de formation --</option>
              <option value="sansdiplome">Sans diplôme</option>
              @foreach($academins as $academin)
                @if($academin->id != 20)
                  <option value="{{ $academin->id }}">{{ $academin->libelle }}</option>
                @endif
              @endforeach
            </select>
          </div>

          <div class="flex-1 degree-only">
            <label for="formations_0_diplome">
              <i class="fas fa-graduation-cap" style="color:#00626D;"></i> Intitulé diplôme
            </label>
            <input type="text" id="formations_0_diplome" name="formations[0][diplome]" class="form-control" placeholder="Intitulé diplôme">
          </div>
        </div>

        <div class="flex gap-5 mt-3 degree-only">
          <div class="flex-1">
            <label for="formations_0_anneediplome">
              <i class="fas fa-calendar-check" style="color:#00626D;"></i> Année d'obtention
            </label>
            <input type="number" id="formations_0_anneediplome" name="formations[0][anneediplome]" class="form-control" placeholder="Année d'obtention" min="1900" max="{{ now()->year }}">
          </div>
          <div class="flex-1">
            <label for="formations_0_specialite">
              <i class="fas fa-cogs" style="color:#00626D;"></i> Spécialité
            </label>
            <input type="text" id="formations_0_specialite" name="formations[0][specialite]" class="form-control" placeholder="Spécialité">
          </div>
        </div>

        <div class="flex gap-5 mt-3 degree-only">
          <div class="flex-1">
            <label for="formations_0_etablissementdiplome">
              <i class="fas fa-school" style="color:#00626D;"></i> Institut
            </label>
            <input type="text" id="formations_0_etablissementdiplome" name="formations[0][etablissementdiplome]" class="form-control" placeholder="Institut">
          </div>

          <div class="flex-1">
                        <label for="formations_0_diplome_file">
                            <i class="fas fa-file-alt" style="color:#00626D;"></i> Joindre un justificatif (facultatif, 4 Mo max)
            </label>
                        <input type="file" id="formations_0_diplome_file" name="formations[0][diplome_file]" accept=".pdf,.doc,.docx,.rtf,.txt,.png,.jpg,.jpeg" class="form-control">
          </div>
        </div>

        <div class="mt-3 flex justify-end">
          <button type="button" class="btn-remove-item remove-formation" style="display:none;">
            Supprimer
          </button>
        </div>
      </div>
    </div>

    <!-- Le bouton reste TOUJOURS en bas -->
    <div id="add-formation-bar" class="mt-4">
      <button type="button" id="add-formation" class="btn-add-item">
        <i class="fas fa-plus mr-2"></i> Ajouter une formation
      </button>
    </div>

    <div class="pgde-action-buttons">
      <button type="button" class="prev-step"><i class="fas fa-arrow-left"></i> <span>Précédent</span></button>
      <button type="button" class="next-step flex items-center"><span>Suivant</span> <i class="fas fa-arrow-right ml-2"></i></button>
    </div>
  </fieldset>
</div>
<script>
(function(){
  const container = document.getElementById('formation-container');
  const addBtn = document.getElementById('add-formation');

  function tplFormation(i){
    return `
      <div class="form-group formation-item" data-index="${i}">
        <div class="flex gap-5">
          <div class="flex-1">
            <label for="formations_${i}_academic_id">
              <i class="fas fa-graduation-cap" style="color:#00626D;"></i> Niveau de formation
              <span class="text-red-500 ml-1">*</span>
            </label>
            <select name="formations[${i}][academic_id]" id="formations_${i}_academic_id"
                    class="form-control shadow-sm academic-select" required>
              <option value="" disabled selected>-- Choisir le niveau de formation --</option>
              <option value="sansdiplome">Sans diplôme</option>
              @foreach($academins as $academin)
                @if($academin->id != 20)
                  <option value="{{ $academin->id }}">{{ $academin->libelle }}</option>
                @endif
              @endforeach
            </select>
          </div>

          <div class="flex-1 degree-only">
            <label for="formations_${i}_diplome">
              <i class="fas fa-graduation-cap" style="color:#00626D;"></i> Intitulé diplôme
            </label>
            <input type="text" id="formations_${i}_diplome" name="formations[${i}][diplome]" class="form-control" placeholder="Intitulé diplôme">
          </div>
        </div>

        <div class="flex gap-5 mt-3 degree-only">
          <div class="flex-1">
            <label for="formations_${i}_anneediplome">
              <i class="fas fa-calendar-check" style="color:#00626D;"></i> Année d'obtention
            </label>
            <input type="number" id="formations_${i}_anneediplome" name="formations[${i}][anneediplome]" class="form-control" placeholder="Année d'obtention" min="1900" max="{{ now()->year }}">
          </div>
          <div class="flex-1">
            <label for="formations_${i}_specialite">
              <i class="fas fa-cogs" style="color:#00626D;"></i> Spécialité
            </label>
            <input type="text" id="formations_${i}_specialite" name="formations[${i}][specialite]" class="form-control" placeholder="Spécialité">
          </div>
        </div>

        <div class="flex gap-5 mt-3 degree-only">
          <div class="flex-1">
            <label for="formations_${i}_etablissementdiplome">
              <i class="fas fa-school" style="color:#00626D;"></i> Institut
            </label>
            <input type="text" id="formations_${i}_etablissementdiplome" name="formations[${i}][etablissementdiplome]" class="form-control" placeholder="Institut">
          </div>
          <div class="flex-1">
                        <label for="formations_${i}_diplome_file">
                            <i class="fas fa-file-alt" style="color:#00626D;"></i> Joindre un justificatif (facultatif, 4 Mo max)
            </label>
                        <input type="file" id="formations_${i}_diplome_file" name="formations[${i}][diplome_file]" accept=".pdf,.doc,.docx,.rtf,.txt,.png,.jpg,.jpeg" class="form-control">
          </div>
        </div>

        <div class="mt-3 flex justify-end">
          <button type="button" class="btn-remove-item remove-formation">
            Supprimer
          </button>
        </div>
      </div>`;
  }

  function toggleDegreeFields(block){
    const select = block.querySelector('.academic-select');
    const isSans = (select && select.value === 'sansdiplome');
    block.querySelectorAll('.degree-only').forEach(el => {
      el.style.display = isSans ? 'none' : '';
      if (isSans){
        el.querySelectorAll('input,select,textarea').forEach(i => { i.value = ''; });
      }
    });
  }

  function wireBlock(block){
    const select = block.querySelector('.academic-select');
    if (select){
      select.addEventListener('change', () => toggleDegreeFields(block));
      toggleDegreeFields(block);
    }
  }

  function addFormation(){
    const i = container.querySelectorAll('.formation-item').length;
    container.insertAdjacentHTML('beforeend', tplFormation(i)); // IMPORTANT : inside container
    const newBlock = container.lastElementChild;
    wireBlock(newBlock);
  }

  // remove (delegation)
  container.addEventListener('click', (e) => {
    if (e.target.classList.contains('remove-formation')){
      const block = e.target.closest('.formation-item');
      block.remove();
      // pas besoin de renuméroter pour le backend: PHP acceptera les clés non continues.
    }
  });

  addBtn.addEventListener('click', addFormation);
  wireBlock(container.querySelector('.formation-item[data-index="0"]'));
})();
</script>

<style>
  /* Harmonisation */
  #add-formation { background:#06843F; }
  #add-formation:hover { background:#45a049; }

  /* Optionnel : garder visuellement le bouton "toujours en bas" du step si la page est courte */
  #add-formation-bar { position: relative; }
</style>

