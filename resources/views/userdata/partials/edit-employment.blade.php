<!-- Step 4: Emploi -->
<div class="form-step" id="step-4" style="display: none;">
  <fieldset>
    <legend style="background-color: #fff; border: 2px solid green; border-radius: 8px; padding: 10px 15px; text-align: center; font-size: 1.0em; font-weight: bold; color:green; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
      <h3 style="margin: 0; font-family: 'Bold'; text-transform: uppercase; letter-spacing: 1px;">Étape 4 : Emploi</h3>
    </legend>

    <div class="mb-3">
      <label for="cv_summary" class="form-label">Résumé du CV (1000 caractères max)</label>
      <textarea id="cv_summary" name="cv_summary" class="form-control" rows="5" maxlength="1000">{{ old('cv_summary', $userdata->cv_summary ?? '') }}</textarea>
    </div>

    <div class="form-group">
      <label for="cv_file"><i class="fas fa-file-alt" style="color:#00626D;"></i> Joindre CV (8 Mo max)</label>
      <input type="file" class="form-control" id="cv_file" name="cv_file[]" accept=".pdf,.doc,.docx,.rtf,.txt" onchange="updateCVList()">
      <ul id="cv_file_list"></ul>
      <input type="hidden" id="deleted_cv_files" name="deleted_cv_files" value="">
    </div>

    <ul id="cv_existing_list" class="mt-2 list-unstyled">
      @if(isset($userdata) && $userdata->cv_file)
        @php $existingCvs = is_array($userdata->cv_file) ? $userdata->cv_file : json_decode($userdata->cv_file, true); @endphp
        @if(is_array($existingCvs))
          @foreach($existingCvs as $file)
            <li id="file-{{ md5($file) }}" class="mb-2">
              📄 <a href="{{ asset($file) }}" target="_blank" class="fw-bold text-dark">{{ basename($file) }}</a>
              <button type="button" class="btn btn-sm btn-danger ms-2" onclick="removeFiles('{{ $file }}', '{{ $userdata->id }}', '{{ md5($file) }}')"><i class="fas fa-trash me-1"></i> Supprimer</button>
            </li>
          @endforeach
        @endif
      @endif
    </ul>

    <div class="form-group" style="display: flex; gap: 20px;">
      <div style="flex: 1;"><label for="emploi1_id"><i class="fas fa-briefcase" style="color:#00626D;"></i> Emploi 1</label><select name="emploi1_id" id="emploi1_id" class="form-select">@foreach($emplois as $emploi)<option value="{{ $emploi->id }}" {{ $emploi->id == $userdata->emploi1_id ? 'selected' : '' }}>{{ $emploi->libelle }}</option>@endforeach</select></div>
      <div style="flex: 1;"><label for="anneeexperience1"><i class="fas fa-building" style="color:#00626D;"></i> Nombre d'années d'expérience</label><input type="number" class="form-control" id="anneeexperience1" name="anneeexperience1" value="{{ $userdata->anneeexperience1 }}"></div>
    </div>

    <div class="form-group" style="display: flex; gap: 20px;">
      <div style="flex: 1;"><label for="emploi2_id"><i class="fas fa-briefcase" style="color:#00626D;"></i> Emploi 2</label><select name="emploi2_id" id="emploi2_id" class="form-select">@foreach($emplois as $emploi)<option value="{{ $emploi->id }}" {{ $emploi->id == $userdata->emploi2_id ? 'selected' : '' }}>{{ $emploi->libelle }}</option>@endforeach</select></div>
      <div style="flex: 1;"><label for="anneeexperience2"><i class="fas fa-building" style="color:#00626D;"></i> Nombre d'années d'expérience</label><input type="number" class="form-control" id="anneeexperience2" name="anneeexperience2" value="{{ $userdata->anneeexperience2 }}"></div>
    </div>

    <div class="button-container">
      <div class="text-center mt-4"><button type="button" class="prev-step"><i class="fa fa-arrow-left"></i> Précédent</button></div>
      <div class="text-center mt-4"><button type="submit" class="btn btn-primary">Soumettre</button></div>
    </div>
  </fieldset>
</div>

<script>
function removeFiles(filePath, userdataId, elementId) {
  if (!confirm('Voulez-vous vraiment supprimer ce fichier ?')) return;
  fetch("{{ route('files.delete') }}", {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}", 'Content-Type': 'application/json' },
    body: JSON.stringify({ file: filePath, userdata_id: userdataId })
  }).then(response => response.json()).then(data => {
    if (data.success) document.getElementById('file-' + elementId)?.remove();
    else alert('Erreur : ' + data.message);
  }).catch(() => alert('Une erreur est survenue.'));
}
</script>
