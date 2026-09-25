<!-- Step 4: Emploi & Profil -->
<div class="form-step" id="step-4" style="display: none;">
  <fieldset>
    <div class="pgde-step-intro">
      <div class="pgde-step-kicker">Étape 4 sur 4</div>
      <h2>Projet professionnel & Emplois ciblés</h2>
      <p>Précisez les types d'emplois recherchés et décrivez votre profil.</p>
    </div>

    <div class="pgde-section-label">Profil & Synthèse</div>

    <div class="form-group mb-4">
      <label for="cv_summary">
        <i class="fas fa-align-left"></i> Résumé de votre profil / Objectif professionnel
      </label>
      <textarea id="cv_summary" name="cv_summary" class="form-control" rows="4" maxlength="1000" placeholder="Présentez brièvement votre profil, vos atouts et ce que vous recherchez...">{{ old('cv_summary', $userdata->cv_summary ?? '') }}</textarea>
      <div class="text-muted small mt-1 text-end" style="font-size: 12px; color: var(--color-text-secondary);">1000 caractères maximum</div>
    </div>

    @if(isset($userdata) && $userdata->cv_file)
      <div class="form-group mb-4">
      <!-- Fichiers existants -->
        @php
          $existingCvs = is_array($userdata->cv_file) ? $userdata->cv_file : json_decode($userdata->cv_file, true);
        @endphp
        @if(is_array($existingCvs) && count($existingCvs) > 0)
          <div class="mt-2 p-2 bg-light rounded border">
            <span class="small fw-semibold text-muted d-block mb-1">CV actuellement enregistré :</span>
            <ul id="cv_existing_list" class="mb-0 list-unstyled">
              @foreach($existingCvs as $file)
                <li id="file-{{ md5($file) }}" class="d-flex align-items-center justify-content-between py-1">
                  <div>
                    <i class="fas fa-file-pdf text-danger me-2"></i>
                    <a href="{{ asset($file) }}" target="_blank" class="fw-semibold text-dark text-decoration-none">{{ basename($file) }}</a>
                  </div>
                  <button type="button" class="btn-remove-item" onclick="removeCVFile('{{ $file }}', '{{ $userdata->id }}', '{{ md5($file) }}')">
                    <i class="fas fa-trash-alt"></i> Supprimer
                  </button>
                </li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>
    @endif

    <div class="pgde-section-label">Emplois ciblés</div>

    <div class="pgde-grid-2">
      <div class="form-group mb-0">
        <label for="emploi1_id"><i class="fas fa-briefcase"></i> Emploi principal souhaité</label>
        <select name="emploi1_id" id="emploi1_id" class="form-select">
          <option value="" disabled {{ empty($userdata->emploi1_id) ? 'selected' : '' }}>-- Sélectionner un emploi --</option>
          @foreach($emplois as $emploi)
            <option value="{{ $emploi->id }}" {{ $emploi->id == $userdata->emploi1_id ? 'selected' : '' }}>{{ $emploi->libelle }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group mb-0">
        <label for="anneeexperience1"><i class="fas fa-history"></i> Années d'expérience sur ce métier</label>
        <input type="number" class="form-control" id="anneeexperience1" name="anneeexperience1" value="{{ $userdata->anneeexperience1 }}" min="0" max="50" placeholder="ex: 2">
      </div>
    </div>

    <div class="pgde-grid-2 mt-3">
      <div class="form-group mb-0">
        <label for="emploi2_id"><i class="fas fa-briefcase"></i> Emploi secondaire souhaité</label>
        <select name="emploi2_id" id="emploi2_id" class="form-select">
          <option value="" disabled {{ empty($userdata->emploi2_id) ? 'selected' : '' }}>-- Sélectionner un second emploi --</option>
          @foreach($emplois as $emploi)
            <option value="{{ $emploi->id }}" {{ $emploi->id == $userdata->emploi2_id ? 'selected' : '' }}>{{ $emploi->libelle }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group mb-0">
        <label for="anneeexperience2"><i class="fas fa-history"></i> Années d'expérience sur ce métier</label>
        <input type="number" class="form-control" id="anneeexperience2" name="anneeexperience2" value="{{ $userdata->anneeexperience2 }}" min="0" max="50" placeholder="ex: 1">
      </div>
    </div>

    <div class="pgde-action-buttons">
      <button type="button" class="prev-step">
        <i class="fas fa-arrow-left"></i> <span>Précédent</span>
      </button>
      <button type="submit" class="next-step btn-submit-step">
        <span>Enregistrer les modifications</span> <i class="fas fa-check"></i>
      </button>
    </div>
  </fieldset>
</div>

<script>
  function removeCVFile(filePath, userdataId, elementId) {
    if (confirm("Voulez-vous vraiment supprimer ce fichier ?")) {
      fetch("{{ route('files.delete') }}", {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": "{{ csrf_token() }}",
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          file: filePath,
          userdata_id: userdataId
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          const el = document.getElementById("file-" + elementId);
          if (el) el.remove();
          Swal.fire({
            icon: 'success',
            title: 'Fichier supprimé',
            timer: 2000,
            showConfirmButton: false
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: data.message || "Erreur lors de la suppression."
          });
        }
      })
      .catch(error => {
        console.error("Erreur :", error);
        alert("Une erreur est survenue.");
      });
    }
  }
</script>
