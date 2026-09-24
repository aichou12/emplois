    <!-- Step 3: Formation -->
    <div class="form-step" id="step-3" style="display:none;">
  <fieldset>
    <div class="pgde-step-intro">
      <div class="pgde-step-kicker">Étape 3 sur 4</div>
      <h2>Expérience professionnelle</h2>
      <p>Décrivez vos expériences professionnelles et les compétences acquises.</p>
    </div>

    <div class="form-group">
      <label for="hasExperience">Avez-vous de l'expérience professionnelle ?</label>
      <select id="hasExperience" name="hasExperience">
        <option value="">-- Choisir --</option>
        <option value="oui">Oui</option>
        <option value="non">Non</option>
      </select>
    </div>

    <div id="experience-wrapper" style="display:none;">
      <div id="experience-container" class="space-y-4">
        <!-- Bloc expérience initial (index 0) -->
        <div class="form-group experience-item" data-index="0">
          <div class="flex gap-5">
            <div class="flex-1">
              <label for="experiences_0_description">
                <i class="fas fa-briefcase" style="color:#00626D;"></i> Expérience professionnelle
              </label>
              <textarea id="experiences_0_description" name="experiences[0][description]" placeholder="Décrivez votre expérience" class="form-control"></textarea>
            </div>
            <div class="flex-1">
              <label for="experiences_0_years">
                <i class="fas fa-cogs" style="color:#00626D;"></i> Nombre d'années d'expérience
              </label>
              <input type="number" id="experiences_0_years" name="experiences[0][years]" class="form-control" placeholder="Années d'expérience">
            </div>
          </div>

          <div class="flex gap-5 mt-3">
            <div class="flex-1">
              <label for="experiences_0_poste">
                <i class="fas fa-briefcase" style="color:#00626D;"></i> Poste occupé
              </label>
              <input type="text" id="experiences_0_poste" name="experiences[0][poste]" class="form-control" placeholder="Poste occupé">
            </div>
            <div class="flex-1">
              <label for="experiences_0_employeur">
                <i class="fas fa-building" style="color:#00626D;"></i> Employeur
              </label>
              <input type="text" id="experiences_0_employeur" name="experiences[0][employeur]" class="form-control" placeholder="Employeur">
            </div>
          </div>

          <div class="mt-3 flex justify-end">
            <button type="button" class="btn-remove-item remove-experience" style="display:none;">
              Supprimer
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
  const hasExp = document.getElementById('hasExperience');
  const wrapper = document.getElementById('experience-wrapper');
  const container = document.getElementById('experience-container');
  const addBtn = document.getElementById('add-experience');

  function tplExperience(i){
    return `
      <div class="form-group experience-item" data-index="${i}">
        <div class="flex gap-5">
          <div class="flex-1">
            <label for="experiences_${i}_description">
              <i class="fas fa-briefcase" style="color:#00626D;"></i> Expérience professionnelle
            </label>
            <textarea id="experiences_${i}_description" name="experiences[${i}][description]" class="form-control" placeholder="Décrivez votre expérience"></textarea>
          </div>
          <div class="flex-1">
            <label for="experiences_${i}_years">
              <i class="fas fa-cogs" style="color:#00626D;"></i> Nombre d'années d'expérience
            </label>
            <input type="number" id="experiences_${i}_years" name="experiences[${i}][years]" class="form-control" placeholder="Années d'expérience">
          </div>
        </div>

        <div class="flex gap-5 mt-3">
          <div class="flex-1">
            <label for="experiences_${i}_poste">
              <i class="fas fa-briefcase" style="color:#00626D;"></i> Poste occupé
            </label>
            <input type="text" id="experiences_${i}_poste" name="experiences[${i}][poste]" class="form-control" placeholder="Poste occupé">
          </div>
          <div class="flex-1">
            <label for="experiences_${i}_employeur">
              <i class="fas fa-building" style="color:#00626D;"></i> Employeur
            </label>
            <input type="text" id="experiences_${i}_employeur" name="experiences[${i}][employeur]" class="form-control" placeholder="Employeur">
          </div>
        </div>

        <div class="mt-3 flex justify-end">
          <button type="button" class="btn-remove-item remove-experience">
            Supprimer
          </button>
        </div>
      </div>`;
  }

  function addExperience(){
    const i = container.querySelectorAll('.experience-item').length;
    container.insertAdjacentHTML('beforeend', tplExperience(i));
  }

  // toggle affichage section expériences
  hasExp.addEventListener('change', () => {
    const show = hasExp.value === 'oui';
    wrapper.style.display = show ? 'block' : 'none';
    if (!show){
      // Optionnel: vider le container (si l'utilisateur repasse à "non")
      // container.innerHTML = container.firstElementChild.outerHTML; // remet à 1 bloc
    }
  });

  // remove (delegation)
  container.addEventListener('click', (e) => {
    if (e.target.classList.contains('remove-experience')){
      const block = e.target.closest('.experience-item');
      block.remove();
    }
  });

  addBtn.addEventListener('click', addExperience);
})();
</script>




